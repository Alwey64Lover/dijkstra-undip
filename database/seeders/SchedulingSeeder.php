<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\CourseDepartment;
use App\Models\CourseDepartmentDetail;
use App\Models\Department;
use App\Models\Lecturer;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchedulingSeeder extends DatabaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYear = AcademicYear::all();
        $informaticsDepartment = Department::where('name', 'Informatika')->first();
        $users = User::where('role', 'academic_division')->get();
        $lecturers = Lecturer::all();

        // room
            $rooms = [
                $this->data([
                    'type' => 'A',
                    'name' => '101',
                    'capacity' => 60, // supaya kaga ribet dengan kondisi ketka max_student course departmennt detail > dari capacity rooms, gua kasih 60
                    'department' => "fisika"
                ]),
                $this->data([
                    'type' => 'E',
                    'name' => '202',
                    'capacity' => 60,
                    'department' => "fisika" // supaya kaga ribet dengan kondisi ketka max_student course departmennt detail > dari capacity rooms, gua kasih 60
                ]),
                $this->data([
                    'type' => 'B',
                    'name' => '203',
                    'capacity' => 60,
                    'department' => "kimia" // supaya kaga ribet dengan kondisi ketka max_student course departmennt detail > dari capacity rooms, gua kasih 60
                ]),
                $this->data([
                    'type' => 'C',
                    'name' => '204',
                    'capacity' => 60,
                    'department' => "Informatika" // supaya kaga ribet dengan kondisi ketka max_student course departmennt detail > dari capacity rooms, gua kasih 60
                ]),
            ];

        // course
            $courses = [
                $this->data([
                    'code' => 'PAIK0080',
                    'name' => 'Dasar Pemrograman',
                ]),
                $this->data([
                    'code' => 'KIAP0140',
                    'name' => 'Matematika I',
                ]),
                $this->data([
                    'code' => 'PAIK6406',
                    'name' => 'Sistem Cerdas',
                ]),
                $this->data([
                    'code' => 'PAIK6404',
                    'name' => 'Grafika dan Komputasi Visual',
                ]),
                $this->data([
                    'code' => 'PAIK6401',
                    'name' => 'Pemrograman Berorientasi Objek',
                ]),
                $this->data([
                    'code' => 'PAIK6403',
                    'name' => 'Manajemen Basis Data',
                ]),
                $this->data([
                    'code' => 'PAIK6601',
                    'name' => 'Analisis dan Strategi Algoritma',
                ]),
                $this->data([
                    'code' => 'PAIK6405',
                    'name' => 'Rekayasa Perangkat Lunak',
                ]),
            ];

        // Course Department
            $courseDepartments = [
                $this->data([
                    'department_id' => $informaticsDepartment->id,
                    'academic_year_id' => collect($academicYear)->where('is_active', true)->first()->id,
                    'action_name' => CourseDepartment::ACTIONS[1],
                    'action_at' => now(),
                    'action_by_id' => $users->random()->id,
                ]),
                $this->data([
                    'department_id' => $informaticsDepartment->id,
                    'academic_year_id' => (collect($academicYear)->where('is_active', false))->random()->id,
                    'action_name' => CourseDepartment::ACTIONS[1],
                    'action_at' => now(),
                    'action_by_id' => $users->random()->id,
                ]),
            ];

            $courseDepartmentDetails = [
                $this->data([
                    'course_department_id' => randomArray($courseDepartments)['id'],
                    'course_id' => randomArray($courses)['id'],
                    'lecturer_ids' => json_encode(collect($lecturers)->pluck('id')->take(rand(0, count($lecturers)))->toArray()),
                    'status' => randomArray(array_keys(CourseDepartmentDetail::STATUSES)),
                    'semester' => rand(1, 14),
                    'sks' => rand(1, 4),
                    'max_student' => rand(40, 60),
                ]),
                $this->data([
                    'course_department_id' => randomArray($courseDepartments)['id'],
                    'course_id' => randomArray($courses)['id'],
                    'lecturer_ids' => json_encode(collect($lecturers)->pluck('id')->take(rand(0, count($lecturers)))->toArray()),
                    'status' => randomArray(array_keys(CourseDepartmentDetail::STATUSES)),
                    'semester' => rand(1, 14),
                    'sks' => rand(1, 4),
                    'max_student' => rand(40, 60),
                ]),
            ];

            $courseClasses = [
                $this->data([
                    'room_id' => randomArray($rooms)['id'],
                    'course_department_detail_id' => randomArray($courseDepartmentDetails)['id'],
                    'name' => 'A',
                    'day' => randomArray(array_keys(CourseClass::DAYS)),
                    'start_time' => '07:00',
                    'end_time' => '09:30',
                ]),
                $this->data([
                    'room_id' => randomArray($rooms)['id'],
                    'course_department_detail_id' => randomArray($courseDepartmentDetails)['id'],
                    'name' => 'D',
                    'day' => randomArray(array_keys(CourseClass::DAYS)),
                    'start_time' => '13:00',
                    'end_time' => '15:30',
                ]),
            ];

        // Insert data
            Room::insert($rooms);
            Course::insert($courses);
            CourseDepartment::insert($courseDepartments);
            CourseDepartmentDetail::insert($courseDepartmentDetails);
            CourseClass::insert($courseClasses);
    }
}
