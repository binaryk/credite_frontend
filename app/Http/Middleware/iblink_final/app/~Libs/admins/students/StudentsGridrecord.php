<?php namespace Libs;

class StudentsGridrecord extends \System\GridsRecord
{
	public function __construct($id)
	{
		parent::__construct($id);

		$this->view           = '~admin_panel.students.index';
		$this->icon           =  NULL;
		$this->caption        = 'Elevi';
		$this->toolbar        = '~admin_panel.students.toolbar';
		$this->name           = 'dt';
		$this->display_start  = 0;
		$this->display_length = 50;
		$this->default_order  = "1,'asc'";
		$this->form           = NULL;
		$this->css            = '';
		$this->js             = 'assets/js/dtable.js';
		$this->row_source     = 'index-students-row-sources';
		$this->rows_source_sql 				= 
			"
			SELECT students.id,students.id id_student, students.lastname nume_elev, students.firstname prenume_elev, students.image imagine_elev, custodians.firstname nume_parinte, 
			custodians.lastname prenume_parinte, custodians.image imagine_parinte, custodians.phone telefon_parinte, groups.name grupa, custodians.id parinte_id
			FROM students
			INNER JOIN users u_s on u_s.userable_id = students.id and u_s.userable_type = 'student'
			LEFT OUTER JOIN custodian_students cs on cs.student_id = u_s.id

			LEFT OUTER JOIN users c_s on c_s.id = cs.custodian_id and c_s.userable_type = 'custodian'
			LEFT OUTER JOIN custodians ON custodians.id = c_s.userable_id 

			LEFT OUTER JOIN group_student ON students.id = group_student.student_id
			LEFT OUTER JOIN groups ON group_student.group_id = groups.id
			GROUP BY students.id
			:where:
			:order:
			";
		$this->count_filtered_records_sql 	= 
			"
			SELECT 
			COUNT(*) as cnt   
			from custodian_students  
			:where:
			";
		$this->count_total_records_sql     	= 
			"
			SELECT 
			COUNT(*) as cnt   
			from custodian_students  
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
				'source'    => '~admin_panel.students.nume',
			],
			'3' => [
				'id'        => 'parinte',
				'orderable' => 'yes',
				'class'     => 'td-record-count td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Părinte', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'view',
				'source'    => '~admin_panel.students.parinte',
			],
			'4' => [
				'id'        => 'phone',
				'orderable' => 'yes',
				'class'     => 'td-record-count td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Telefon tutore legal', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'field',
				'source'    => 'telefon_parinte',
			],
			'5' => [
				'id'        => 'grupa',
				'orderable' => 'yes',
				'class'     => 'td-record-count td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Clasa/Grupa', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'field',
				'source'    => 'grupa',
			],
			'6' => [
				'id'        => 'actions_suplimentare',
				'orderable' => 'yes',
				'class'     => 'td-record-count td-align-left actions',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Acțiuni', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'view',
				'source'    => '~admin_panel.students.actions_suplimentare',
			],
			'7' => [
				'id'        => 'actions',
				'orderable' => 'yes',
				'class'     => 'td-record-count td-align-left actions',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Acțiuni', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'view',
				'source'    => '~admin_panel.students.actions',
			], 
			
		];
		$this->fields = [
			'fields'      => '',
			'searchables' => 'sp.prenume_elev',
			'orderables'  => [1 => '1'],
		];
		$this->filters = [];

	}

    public static function create()
	{
		return self::$instance = new StudentsGridrecord('students-index');
	}
	
}