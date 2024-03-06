<?php

namespace App\Exports;

use App\Models\StudentExam;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentExamExport  implements WithHeadings, WithStyles, FromQuery, WithColumnWidths

{

    use Exportable;


    protected $filiters;

     /**
     * @param $filiters
     * @return \Illuminate\Support\Collection
     */
    public function __construct($filiters)
    {
        $this->filiters = $filiters;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        $query = StudentExam::query()
            ->join('users', 'users.id', '=', 'student_exams.user_id')
            ->join('groups', 'groups.id', '=', 'users.group_id')
            ->join('group_translations', 'groups.id', '=', 'group_translations.group_id')
            ->join('exams', 'exams.id', '=', 'student_exams.exam_id')
            ->join('exam_translations', 'exams.id', '=', 'exam_translations.exam_id')
            ->where('student_exams.is_finished', 1)
            ->select(
                'exam_translations.title',
                DB::raw('CONCAT(users.first_name, " ", users.last_name) as name'),
                'users.phone',
                'group_translations.title as group',
                'exams.grade',
                'student_exams.student_grade',
                'student_exams.current_time'
            );

        if (isset($this->filiters['exam_id'])) {
            $query->where('student_exams.exam_id', $this->filiters['exam_id']);
        }

        if (isset($this->filiters['group_id'])) {
            $query->where('users.group_id', $this->filiters['group_id']);

        }
        if (isset($this->filiters['level_id'])) {
            $query->where('users.level_id', $this->filiters['level_id']);

        }

        if (isset($this->filiters['search'])) {
            $query->where('users.first_name', 'LIKE', '%' . $this->filiters['search'] . '%')
                ->orWhere('users.phone', 'LIKE', '%' . $this->filiters['search'] . '%');

        }

        if (isset($this->filiters['sort'])) {
            $query->orderBy('student_exams.student_grade', $this->filiters['sort']);
        }
        // dd($query->get());

        return $query;
    }


      /**
     * show head of table
     * @return array
     */
    public function headings(): array
    {
        return ['الامتحان', 'الطالب', 'رقم الهاتف', 'المجموعه' ,'درجه الامتحان', 'درجة الطالب','وقت الانتهاء بالدقائق'];
    }


    /**
     * styles of table
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => '539BFF']],
            ],
        ];
    }


    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
            'C' => 30,
            'D' => 50,
            'E' => 20,
            'F' => 20,
            'G' => 40,
        ];
    }

}
