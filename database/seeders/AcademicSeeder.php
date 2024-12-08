<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\CourseClass;
use App\Models\HerRegistration;
use App\Models\Irs;
use App\Models\IrsDetail;
use App\Models\Khs;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicSeeder extends DatabaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYears = AcademicYear::all()->toArray();
        $courseClasses = CourseClass::all()->toArray();

        // Her Registration
            $students = Student::with('lecturer.user')->get();

            $herRegistrations = [];
            foreach ($students as $keyStudent => $student) {
                $i = 1;
                foreach ($academicYears as $keyAcademicYear => $academicYear) {
                    // for ($i=1; $i <= 6; $i++) {
                    $herRegistrations[] =
                        $this->data([
                            'student_id' => $student->id,
                            'academic_year_id' => $academicYear['id'],
                            'semester' => $i,
                            'status' => 0,
                        ]);
                    // }
                    $i++;
                }
            }

            HerRegistration::insert($herRegistrations);



        // IRS
            $irss = [];
            foreach ($herRegistrations as $keyHerRegistration => $herRegistration) {
                $irss[] = $this->data([
                    'her_registration_id' => $herRegistration['id'],
                    'semester' => $herRegistration['semester'],
                    'status_name' => array_keys(Irs::STATUSES)[1],
                    'status_at' => now(),
                    'is_submitted' => true,
                    'status_by_id' => $student->lecturer->user->id,
                    'action_name' => array_keys(Irs::ACTIONS)[1],
                    'action_at' => now(),
                    'action_by_id' => $student->lecturer->user->id,
                ]);
            }

            Irs::insert($irss);


        // irs details
            $irss = Irs::all();
            $irsDetails = [];

            foreach ($irss as $keyIrs => $irs) {

                $courseClasses = CourseClass::whereHas('CourseDepartmentDetail', function($query) use($irs) {
                    $query->whereHas('courseDepartment', function($query) use($irs) {
                        $query->where('academic_year_id', $irs->herRegistration->academic_year_id);
                    });
                })->inRandomOrder()->get();


                $totalSks = 0;
                foreach ($courseClasses as $key => $courseClass) {
                    if ($courseClass->CourseDepartmentDetail && $totalSks + $courseClass->CourseDepartmentDetail->sks <= 24) {
                        $irsDetails[] = $this->data([
                            'irs_id' => $irs->id,
                            'course_class_id' => $courseClass->id,
                            'sks' => $courseClass->CourseDepartmentDetail->sks,
                            'retrieval_status' => 0,
                        ]);

                        $totalSks += $courseClass->CourseDepartmentDetail->sks;
                    }

                    if ($totalSks >= 24) {
                        break;
                    }
                }
            }

            // $khs = [
            //     $this->data([
            //         'irs_detail_id' => $irsDetails[0]['id'],
            //         'score' => 80
            //     ])
            // ];

        // Insert Data
            IrsDetail::insert($irsDetails);
            // Khs::insert($khs);
    }
}
