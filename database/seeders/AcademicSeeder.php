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
            $student = Student::where('nim', '24060122140044')->with('lecturer.user')->first();

            $herRegistrations = [
                $this->data([
                    'student_id' => $student->id,
                    'academic_year_id' => $academicYears[0]['id'],
                    'semester' => 1,
                    'status' => array_keys(HerRegistration::STATUSES)[0],
                ]),
                $this->data([
                    'student_id' => $student->id,
                    'academic_year_id' => $academicYears[1]['id'],
                    'semester' => 2,
                    'status' => array_keys(HerRegistration::STATUSES)[0],
                ]),
                $this->data([
                    'student_id' => $student->id,
                    'academic_year_id' => $academicYears[2]['id'],
                    'semester' => 3,
                    'status' => array_keys(HerRegistration::STATUSES)[0],
                ]),
                $this->data([
                    'student_id' => $student->id,
                    'academic_year_id' => $academicYears[3]['id'],
                    'semester' => 4,
                    'status' => array_keys(HerRegistration::STATUSES)[0],
                ]),
                $this->data([
                    'student_id' => $student->id,
                    'academic_year_id' => $academicYears[4]['id'],
                    'semester' => 5,
                    'status' => array_keys(HerRegistration::STATUSES)[0],
                ]),
            ];

        // IRS
            $irss = [
                $this->data([
                    'her_registration_id' => $herRegistrations[0]['id'],
                    'status_name' => array_keys(Irs::STATUSES)[1],
                    'status_at' => now(),
                    'status_by_id' => $student->lecturer->user->id,
                    'action_name' => array_keys(Irs::ACTIONS)[1],
                    'action_at' => now(),
                    'action_by_id' => $student->lecturer->user->id,
                ]),
                $this->data([
                    'her_registration_id' => $herRegistrations[1]['id'],
                    'status_name' => array_keys(Irs::STATUSES)[1],
                    'status_at' => now(),
                    'status_by_id' => $student->lecturer->user->id,
                    'action_name' => array_keys(Irs::ACTIONS)[1],
                    'action_at' => now(),
                    'action_by_id' => $student->lecturer->user->id,
                ]),
                $this->data([
                    'her_registration_id' => $herRegistrations[2]['id'],
                    'status_name' => array_keys(Irs::STATUSES)[1],
                    'status_at' => now(),
                    'status_by_id' => $student->lecturer->user->id,
                    'action_name' => array_keys(Irs::ACTIONS)[1],
                    'action_at' => now(),
                    'action_by_id' => $student->lecturer->user->id,
                ]),
                $this->data([
                    'her_registration_id' => $herRegistrations[3]['id'],
                    'status_name' => array_keys(Irs::STATUSES)[1],
                    'status_at' => now(),
                    'status_by_id' => $student->lecturer->user->id,
                    'action_name' => array_keys(Irs::ACTIONS)[1],
                    'action_at' => now(),
                    'action_by_id' => $student->lecturer->user->id,
                ]),
                $this->data([
                    'her_registration_id' => $herRegistrations[4]['id'],
                    'status_name' => array_keys(Irs::STATUSES)[1],
                    'status_at' => now(),
                    'status_by_id' => $student->lecturer->user->id,
                    'action_name' => array_keys(Irs::ACTIONS)[1],
                    'action_at' => now(),
                    'action_by_id' => $student->lecturer->user->id,
                ]),
            ];

        // irs details
            $irsDetails = [
                // Semester 1
                $this->data([
                    'irs_id' => $irss[0]['id'],
                    'course_class_id' => $courseClasses[0]['id'],
                    'sks' => 4,
                    'retrieval_status' => $student->lecturer->user->id,
                ]),

                // Semester 2
                // Semester 3
                // Semester 4
                // Semester 5
            ];

            $khs = [
                $this->data([
                    'irs_detail_id' => $irsDetails[0]['id'],
                    'score' => 80
                ])
            ];

        // Insert Data
            HerRegistration::insert($herRegistrations);
            Irs::insert($irss);
            IrsDetail::insert($irsDetails);
            Khs::insert($khs);
    }
}
