<?php

namespace App\Http\Controllers;

use App\Models\CourseClass;
use App\Models\CourseDepartmentDetail;
use App\Models\HerRegistration;
use App\Models\Irs;
use App\Models\IrsDetail;
use App\Models\IrsTemporaryCourse;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;

class IrsController extends Controller
{
    public function table(Request $request)
    {
        try{
            $studentId = user()->student->id;
            $latestSemester = (int) HerRegistration::where('student_id', $studentId)
                ->whereHas('irs', function($query){
                    $query->where('action_name', 1);
                })
                ->orderBy('semester', 'desc')
                ->value('semester');

                $selectedSemester = $request->semester ?? $latestSemester;
            // $selectedSemester = $request->semester ?? $latestSemester;

            // dd($selectedSemester);

            $data['irsmhs'] = IrsDetail::whereHas('irs', function($query) use ($selectedSemester,$studentId){
                $query->whereHas('herRegistration', function($query) use($studentId, $selectedSemester){
                    $query->where([
                        ['student_id', $studentId],
                        ['semester', $selectedSemester]
                    ]);
                });
            })
            ->with(['courseClass', 'courseClass.CourseDepartmentDetail.course',
            'courseClass.CourseDepartmentDetail.lecturers.user', 'courseClass.room'])
            ->get();

            if($request->ajax()){
                $html = view('modules.student.irstable', ['irsmhs' => $data['irsmhs']])->render();
                return response()->json(['html'=>$html]);
            }

            $data['options'] = HerRegistration::where('student_id', user()->student->id)
            ->whereHas('irs', function($query){
                $query->where('action_name', 1);
            })
            ->orderBy('semester')
            ->pluck('semester', 'semester')
            ->mapWithKeys(function ($semester) {
                return [$semester => "Semester ".$semester];
            })
            ->toArray();
            $data['semester'] = [
                'type' => 'select',
                'id' => 'semester',
                'name' => 'semester',
                'disabledPlaceholder' => false,
                'value' => $selectedSemester,
                'options' => $data['options']
            ];

            $html = view('modules.student.irstable', ['irsmhs' => $data['irsmhs']])->render();

            // @dd($data);
            return view('modules.student.irsindex', array_merge($data, [
                'initialContent' => $html,
                'selectedSemester' => $selectedSemester,
                'latestSemester' => $latestSemester]));
            }catch(Exception $e){
            logError($e, actionMessage("failed", "retrieved"), 'showingirs');
        }
    }

    public function form(string $action, string $id = null)
    {
        try {
            $studentId = user()->student->id;
            $timeSlots = ['06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21'];
            $days = CourseClass::DAYS;

            $schedule = [
                'SENIN' => [
                    '07:00' => ['name' => 'Matematika I', 'status' => 'Wajib', 'sks' => 2, 'time' => '07:00 - 09:30', 'class' => 'A', 'color' => 'success'],
                    '09:40' => ['name' => 'Pembelajaran Mesin', 'status' => 'Wajib', 'sks' => 3, 'time' => '09:40 - 12:10', 'class' => 'B', 'color' => 'success'],
                ],
                'SELASA' => [
                    '07:00' => ['name' => 'Matematika I', 'status' => 'Wajib', 'sks' => 2, 'time' => '07:00 - 09:30', 'class' => 'D', 'color' => 'success'],
                    '09:40' => ['name' => 'Teori Bahasa dan Otomata', 'status' => 'Pilihan', 'sks' => 3, 'time' => '09:40 - 12:10', 'class' => 'A', 'color' => 'primary'],
                ],
            ];
            // $data['availablecourses'] = IrsDetail::whereHas('irs', function($query) use ($studentId){
            //     $query->where('student_id', $studentId)
            //             ->whereIn('semester', [1,2,3]);
            // })
            // ->with(['courseClass', 'courseClass.CourseDetail.course',
            // 'courseClass.CourseDetail.lecturers.user', 'courseClass.room'])
            // ->get();


            $schedules = json_decode(academicYear()->schedules);
            $latestSemester = activeIrs()->semester;

            $data['availablecourses'] = CourseDepartmentDetail::
                whereHas('courseDepartment', function($query){
                    $query->where('academic_year_id', academicYearId());
                })
                ->where(function($query) use($schedules, $latestSemester){
                    // dd(strtotime(date('Y-m-d H:i:s')), strtotime(date('Y-m-d H:i:s', strtotime($schedules->irs_filling_priority->start))));
                    if (strtotime(date('Y-m-d H:i:s')) < strtotime(date('Y-m-d H:i:s', strtotime($schedules->irs_filling_general->start)))) {
                        $query->where('semester', $latestSemester);
                    }
                })
                ->with('course')
                ->get()
                ->groupBy('semester');

            $availablecourses = $data['availablecourses'] ?? [];

            $irsTemporaries = IrsTemporaryCourse::where('irs_id', activeIrs()->id)->first();

            return view('modules.student.irsnew', compact('timeSlots', 'days', 'schedule','availablecourses', 'irsTemporaries'));
        } catch (Exception $e) {
            logError($e, actionMessage("failed", "retrieved"), 'creatingirs');
        }
    }

    public function getCourseClass(Request $request){
        $courseIds = $request->courseIds ?? [];

        $data = CourseClass::whereIn('course_department_detail_id', $courseIds)
            ->with([
                'CourseDepartmentDetail.course',
                'room',
                'irsInfo' => function($query){
                    $query->where('irs_id', activeIrs()->id);
                }
            ])
            ->get()
            ->map(function ($courseClass) use ($courseIds) {
                if ($courseClass->irsInfo->isNotEmpty()) {
                    $courseClass->status_color = 'success';
                } elseif (CourseClass::where('course_department_detail_id', $courseClass->course_department_detail_id)
                        ->get()
                        ->contains(function ($item) {
                            return $item->irsInfo->isNotEmpty();
                        })
                ) {
                    $courseClass->status_color = 'secondary';
                } elseif (CourseClass::where('course_department_detail_id', $courseClass->course_department_detail_id)
                        ->get()
                        ->every(function ($item) {
                            return $item->irsInfo->isEmpty();
                        })
                ) {
                    $courseClass->status_color = 'warning';
                } else {
                    $courseClass->status_color = 'secondary';
                }
                return $courseClass;
            })
            ->groupBy(function($item){
                return $item->day.' - '.date('H', strtotime($item->start_time));
            })
            ->map(function ($group) {
                foreach ($group as $courseClass) {
                    if ($courseClass->status_color === 'success') continue;
                    $overlapping = $group->first(function ($item) use ($courseClass) {
                        return $item->id !== $courseClass->id
                            && $item->day === $courseClass->day
                            && $item->start_time < $courseClass->end_time
                            && $item->end_time > $courseClass->start_time
                            && $item->irsInfo->isNotEmpty();
                    });

                    if ($overlapping) {
                        $courseClass->status_color = 'danger';
                    }
                }

                return $group;
            });
        if (!activeIrs()->is_submitted) {
            IrsTemporaryCourse::updateOrCreate(
                [
                    'irs_id' => activeIrs()->id,
                ],
                [
                    'course_ids' => json_encode($courseIds),
                ]
            );
        }

        return response($data);
    }

    public function acceptSome (Request $request){
        foreach (explode(',', $request->input('selectedStudents', '')) as $i => $studentId) {
            // dd(($studentId));
            activeIrs($studentId)->update([
                'action_name' => '1',
                'action_by' => user()->lecturer->id,
                'action_at' => now()
            ]);
        }

        return redirect()->back()->with('success', 'IRS berhasil disetujui!');
    }

    public function accept(Irs $irs){
        $irs->update([
            'action_name' => '1',
            'action_by' => user()->lecturer->id,
            'action_at' => now()
        ]);

        return redirect()->back()->with('success', 'IRS berhasil disetujui!');
    }

    public function reject(Irs $irs){
        $irs->update(['action_name' => 0]);

        return redirect()->back()->with('error', 'IRS berhasil dibatalkan!');
    }

    public function submitIrs(){
        activeIrs()->update([
            'is_submitted' => !activeIrs()->is_submitted,
            'action_name' => 0,
            'action_at' => now(),
        ]);

        $message = activeIrs()->is_submitted ? 'unsubmit' : 'submit';

        return redirect()->back()->with('success', 'IRS berhasil di'.$message.'!');
    }

    public function exportPdf()
    {
        try {
            // Ambil data IRS mahasiswa
            $studentId = user()->student->id; // Pastikan user login memiliki relasi student
            $studentName = user()->name;
            $studentNim = user()->student->nim;
            // $tahunakdmk = AcademicYears::get();
            // dd($studentName);
            $latestSemester = (int) Irs::where('student_id', $studentId)
            ->orderBy('semester', 'desc')
            ->value('semester') - 1;
            $selectedSemester = $request->semester ?? $latestSemester;

            $irsmhs = IrsDetail::whereHas('irs', function ($query) use ($studentId) {
                $query->where('student_id', $studentId)
                      ->where('semester', 1);
            })
            ->with([
                'courseClass.CourseDepartmentDetail.course',
                'courseClass.CourseDepartmentDetail.lecturers.user',
                'courseClass.room'
            ])
            ->get();

            // Jika data kosong, tampilkan pesan error
            if ($irsmhs->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada data IRS untuk diekspor.');
            }

            // Render view untuk PDF dan pastikan semester dipassing ke view
            $pdf = Pdf::loadView('modules.student.pdf.irs', compact('irsmhs', 'latestSemester', 'studentName', 'studentNim'));

            // Unduh file PDF
            return $pdf->download('IRS-Mahasiswa.pdf');
        } catch (Exception $e) {
            // Log error dan tampilkan pesan error
            logError($e, actionMessage("failed", "retrieved"), 'exporting IRS PDF');
            return redirect()->back()->with('error', 'Gagal membuat PDF: ' . $e->getMessage());
        }
    }

    public function action(Request $request, string $action, string $id = null)
    {
        $courseClass = CourseClass::with('CourseDepartmentDetail')->find($request->courseClassId);

        switch ($action) {
            case 'add':
                IrsDetail::updateOrCreate(
                    [
                        'irs_id' => activeIrs()->id,
                        'course_class_id' => $courseClass->id,
                    ],
                    [
                        'sks' => @$courseClass->CourseDepartmentDetail->sks,
                        'retrieval_status' => 0,
                    ]
                );

                break;
            case 'delete':
                IrsDetail::where('irs_id', activeIrs()->id)
                    ->where('course_class_id', $courseClass->id)
                    ->first()
                    ->delete();
                break;
            default:
                throw new Exception("Action ".$action." not found.");
        }

        return redirect()->back()->with('success', 'Action success!');
    }
}
