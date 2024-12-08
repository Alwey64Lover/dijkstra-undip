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
        $rooms = Room::all();
        $informaticsDepartment = Department::where('name', 'Informatika')->first();
        $users = User::where('role', 'academic_division')->get();
        $lecturers = Lecturer::all();

        // room
            // Room ku pindah di RoomSeeder.php - Fons

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
                $this->data([
                    'code' => 'PAIK6511',
                    'name' => 'Pembelajaran Mesin',
                ]),
                $this->data([
                    'code' => 'PAIK6407',
                    'name' => 'Komputasi Tersebar dan Paralel',
                ]),
                $this->data([
                    'code' => 'PAIK6408',
                    'name' => 'Teori Bahasa dan Otomata',
                ]),
                $this->data([
                    'code' => 'PAIK6409',
                    'name' => 'Sistem Informasi',
                ]),
                $this->data([
                    'code' => 'PAIK6410',
                    'name' => 'Pengembangan Perangkat Lunak',
                ]),
                $this->data([
                    'code' => 'PAIK6411',
                    'name' => 'Pemrograman Berbasis Platform',
                ]),
                $this->data([
                    'code' => 'PAIK6412',
                    'name' => 'Keamanan dan Jaminan Informasi',
                ]),
                $this->data([
                    'code' => 'PAIK6413',
                    'name' => 'Interaksi Manusia dan Komputer',
                ])
            ];

        // Course Department
            $courseDepartments = $academicYear->map(function($year) use ($informaticsDepartment, $users) {
                return $this->data([
                    'department_id' => $informaticsDepartment->id,
                    'academic_year_id' => $year->id,
                    'action_name' => $year->name === '2024/2025 Genap' ? CourseDepartment::ACTIONS[0] : CourseDepartment::ACTIONS[1],
                    'is_submitted'=> $year->name === '2024/2025 Genap' ? false : true,
                    'action_at' => now(),
                    'action_by_id' => $users->random()->id,
                ]);
            })->toArray();

            $courseDepartmentDetails = [];

            for ($i=0; $i <= 5; $i++) {
                foreach ($courses as $key => $c) {
                    // dd($courseDepartments[4]['id'],$courseDepartments[3]['id'],$courseDepartments[2]['id'],$courseDepartments[1]['id'], $courseDepartments[0]['id']);
                    $courseDepartmentDetails[] =
                        $this->data([
                            'course_department_id' => $courseDepartments[$i]['id'],
                            'course_id' => $c['id'],
                            'lecturer_ids' => json_encode(collect($lecturers)->pluck('id')->take(rand(1, count($lecturers)))->toArray()),
                            'status' => randomArray(array_keys(CourseDepartmentDetail::STATUSES)),
                            'semester' => rand(1, 8),
                            'sks' => rand(1, 4),
                            'max_student' => rand(40, 60),
                        ]);

                }
            }

            $courseClasses = [];

            $times = [];
            for ($hour = 7; $hour <= 18; $hour++) {
                for ($minute = 0; $minute < 60; $minute += 10) {
                    $times[] = sprintf("%02d:%02d", $hour, $minute);
                }
            }

            foreach ($courseDepartmentDetails as $key => $courseDepartmentDetail) {
                $start = $times[rand(0, count($times) - 1)];
                $end = date('H:i', strtotime($times[rand(0, count($times) - 1)]) + 60 * 60);
                // dd($courseDepartmentDetail);
                $courseClasses[] =
                    $this->data([
                        'room_id' => $rooms[rand(0, count($rooms) - 1)]['id'],
                        'course_department_detail_id' => $courseDepartmentDetail['id'],
                        'name' => 'A',
                        'day' => array_keys(CourseClass::DAYS)[0],
                        'start_time' => $start,
                        'end_time' => $end,
                    ]);
            }

        // Insert data
            Course::insert($courses);
            CourseDepartment::insert($courseDepartments);
            CourseDepartmentDetail::insert($courseDepartmentDetails);
            CourseClass::insert($courseClasses);
    }
}
