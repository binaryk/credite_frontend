<?php namespace Libs;

class TeachersGridrecord extends \System\GridsRecord
{
	public function __construct($id)
	{
		parent::__construct($id);

		$this->view           = '~admin_panel.teachers.index';
		$this->icon           =  NULL;
		$this->caption        = 'Profesori/Învățători';
		$this->toolbar        = '~admin_panel.teachers.toolbar';
		$this->name           = 'dt';
		$this->display_start  = 0;
		$this->display_length = 50;
		$this->default_order  = "1,'asc'";
		$this->form           = NULL;
		$this->css            = '';
		$this->js             = 'assets/js/dtable.js';
		$this->row_source     = 'index-teachers-row-sources';
		$this->rows_source_sql 				= 
			"
			SELECT 
				teachers.id,
				teachers.firstname,
				teachers.lastname,
				teachers.phone,
				teachers.image,
				users.email,
				users.id as user_id,
				subject_teacher_group.subject_id,
				groups.name as clasa
				from teachers
				left join users 
				ON teachers.id = users.userable_id 
				left join subject_teacher_group
				ON users.id = subject_teacher_group.user_id
				LEFT JOIN groups 
				ON groups.id = subject_teacher_group.group_id
				WHERE
				users.userable_type LIKE \"%teacher%\"
				GROUP BY users.id
			:where:
			:order:
			";
		$this->count_filtered_records_sql 	= 
			"
			SELECT 
				COUNT(*) as cnt   
				from teachers
				left join users 
				ON teachers.id = users.userable_id 
				left join subject_teacher_group
				ON users.id = subject_teacher_group.user_id
				LEFT JOIN groups 
				ON groups.id = subject_teacher_group.group_id
				WHERE
				users.userable_type LIKE \"%teacher%\"
				GROUP BY users.id
			:where:
			";
		$this->count_total_records_sql     	= 
			"
			SELECT 
				COUNT(*) as cnt   
				from teachers
				left join users 
				ON teachers.id = users.userable_id 
				left join subject_teacher_group
				ON users.id = subject_teacher_group.user_id
				LEFT JOIN groups 
				ON groups.id = subject_teacher_group.group_id
				WHERE
				users.userable_type LIKE \"%teacher%\"
				GROUP BY users.id
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
				'id'        => 'name',
				'orderable' => 'yes',
				'class'     => 'td-record-count td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Nume', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'view',
				'source'    => '~admin_panel.teachers.nume',
			],
			'3' => [
				'id'        => 'email',
				'orderable' => 'yes',
				'class'     => 'td-record-count td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Email', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'field',
				'source'    => 'email',
			],
			'4' => [
				'id'        => 'phone',
				'orderable' => 'yes',
				'class'     => 'td-record-count td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Telefon', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'field',
				'source'    => 'phone',
			],
			'5' => [
				'id'        => 'clasa',
				'orderable' => 'yes',
				'class'     => 'td-record-count td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Clasa', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'field',
				'source'    => 'clasa',
			],
			'6' => [
				'id'        => 'actions',
				'orderable' => 'yes',
				'class'     => 'td-record-count td-align-left actions',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Acțiuni', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'view',
				'source'    => '~admin_panel.teachers.actions',
			], 
			
		];
		$this->fields = [
			'fields'      => '',
			'searchables' => 'teachers.firstname, teachers.lastname',
			'orderables'  => [1 => '1'],
		];
		$this->filters = [];

	}

    public static function create()
	{
		return self::$instance = new TeachersGridrecord('teachers-index');
	}
	
}