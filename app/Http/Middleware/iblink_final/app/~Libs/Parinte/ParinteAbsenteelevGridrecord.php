<?php namespace Libs;

class ParinteAbsenteelevGridrecord extends \System\GridsRecord
{
	// https://www.iconfinder.com/iconsets/fatcow
	public function __construct($id)
	{
		parent::__construct($id);

		$this->view           = '~libs.parinte.absente-elev.index';
		$this->icon           =  NULL;
		$this->caption        = 'Absente elev';
		$this->toolbar        = '~libs.parinte.absente-elev.toolbar';
		$this->name           = 'dt';
		$this->display_start  = 0;
		$this->display_length = 50;
		$this->default_order  = "1,'asc'";
		$this->form           = NULL;
		$this->css            = '';
		$this->js             = '~libs/customs/js/parinte-absente-elev.js';
		$this->row_source     = 'index-parinte-absente-elev-row-sources';
		$this->rows_source_sql 				= 
			"
			SELECT
                subject_teacher_group.*,
                subjects.name as materia, subjects.grading_system,
                teachers.id as teacher_id, teachers.firstname, teachers.lastname, teachers.image
            FROM subject_teacher_group
            LEFT JOIN subjects ON subject_teacher_group.subject_id = subjects.id
            LEFT JOIN users
                LEFT JOIN teachers 
                ON users.userable_id = teachers.id
            ON subject_teacher_group.user_id = users.id
			:where:
			:order:
			";
		$this->count_filtered_records_sql 	= 
			"
			SELECT 
				COUNT(*) as cnt 
			FROM subject_teacher_group
            LEFT JOIN subjects ON subject_teacher_group.subject_id = subjects.id
            LEFT JOIN users
                LEFT JOIN teachers 
                ON users.userable_id = teachers.id
            ON subject_teacher_group.user_id = users.id
			:where:
			";
		$this->count_total_records_sql     	= 
			"
			SELECT 
				COUNT(*) as cnt 
			FROM subject_teacher_group 
			";
		$this->columns        = [
			'1' => [
				'id'        => '#',
				'orderable' => 'no',
				'class'     => 'td-record-count td-align-center',
				'visible'   => 'yes',
				'header'    => ['caption' => '#', 'style'   => 'width:5%; text-align:center',],
				'type'      => 'row-number',
				'source'    => 'row-number',
			],
			'2' => [
				'id'        => 'materia',
				'orderable' => 'yes',
				'class'     => 'td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Materia', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'view',
				'source'    => '~libs.parinte.absente-elev.materia',
			],
			'3' => [
				'id'        => 'absente',
				'orderable' => 'no',
				'class'     => 'td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Absenţe', 'style'   => 'width:65%; text-align:center',],
				'type'      => 'view',
				'source'    => '~libs.parinte.absente-elev.absente',
			],
			'4' => [
				'id'        => 'total',
				'orderable' => 'no',
				'class'     => 'td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Număr de absenţe', 'style'   => 'width:10%; text-align:center',],
				'type'      => 'view',
				'source'    => '~libs.parinte.absente-elev.total',
			],
		];
		$this->fields = [
			'fields'      => '',
			'searchables' => '',
			'orderables'  => [
				1 => 'subjects.name'
			],
		];
		$this->filters = [];

	}

    public static function create()
	{
		return self::$instance = new ParinteAbsenteelevGridrecord('parinte-absente-elev');
	}
	
}