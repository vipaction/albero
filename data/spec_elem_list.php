<?php
$doors = array(
	/*
		pillar = Стойка
		filling = Филенка
		crossbar = Перемычка
		glass = Стекло
		jamb = Наличник
		extend = Расширитель
		frame = Коробка
		decor = Декор
	*/
	"101"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"glass","border_height"=>15, "border_width"=>15),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110),
	),

	"102"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"filling","border_height"=>15, "border_width"=>15),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110),
	),

	"103"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"glass","border_height"=>15, "border_width"=>15),
			array("type"=>"crossbar","height"=>110),
			array("type"=>"glass","height"=>(750-130-110),"border_height"=>15, "border_width"=>15),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110),
	),

	"104"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"glass","border_height"=>15, "border_width"=>15),
			array("type"=>"crossbar","height"=>110),
			array("type"=>"filling","height"=>(750-130-110),"border_height"=>15, "border_width"=>15),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110),
	),

	"105"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"filling","border_height"=>15, "border_width"=>15),
			array("type"=>"crossbar","height"=>110),
			array("type"=>"filling","height"=>(750-130-110),"border_height"=>15, "border_width"=>15),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110),
	),

	"106"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"glass","border_height"=>15, "border_width"=>15),
			array("type"=>"decor","height"=>30),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"decor","width"=>30),
		array("type"=>"pillar","width"=>110),
	),

	"201"=>array(		/* начальные данные по каждой модели двери */
		array("type"=>"pillar",'width'=>110),	/* описание элементов дверей */
		array("type"=>"container", 'value'=>array(
			array("type"=>"crossbar",'height'=>110),
			array("type"=>"filling",'border_height'=>15, 'border_width'=>15),
			array("type"=>"crossbar",'height'=>90),							/* тонкие перемычки */
			array("type"=>"glass",'height'=>50, 'border_height'=>15, 'border_width'=>15),
			array("type"=>"crossbar",'height'=>90),							/* тонкие перемычки */
			/* высота ручки по середине вставки стекла, 
			высота филенки = 950(высота до ручки)-130(высота нижней перемычки)-90(высота тонкой перемычки)-25(половина высоты стекла) */
			array("type"=>"filling",'height'=>(950-130-25-90), 'border_height'=>15, 'border_width'=>15),	
			array("type"=>"crossbar",'height'=>130))
		),
		array("type"=>"pillar",'width'=>110)
	),

	"202"=>array(		
		array("type"=>"pillar",'width'=>110),	
		array("type"=>"container", 'value'=>array(
			array("type"=>"crossbar",'height'=>110),
			array("type"=>"glass",'border_height'=>15, 'border_width'=>15),
			array("type"=>"crossbar",'height'=>90),							/* тонкие перемычки */
			array("type"=>"glass",'height'=>50, 'border_height'=>15, 'border_width'=>15),
			array("type"=>"crossbar",'height'=>90),							/* тонкие перемычки */
			/* высота ручки по середине вставки стекла, 
			высота стекла = 950(высота до ручки)-130(высота нижней перемычки)-90(высота тонкой перемычки)-25(половина высоты стекла) */
			array("type"=>"glass",'height'=>(950-130-25-90), 'border_height'=>15, 'border_width'=>15),	
			array("type"=>"crossbar",'height'=>130))
		),
		array("type"=>"pillar",'width'=>110)
	),

	"203"=>array(		
		array("type"=>"pillar",'width'=>110),	
		array("type"=>"container", 'value'=>array(
			array("type"=>"crossbar",'height'=>110),
			array("type"=>"glass",'border_height'=>15, 'border_width'=>15),
			array("type"=>"crossbar",'height'=>90),							
			array("type"=>"glass",'border_height'=>15, 'border_width'=>15),
			array("type"=>"crossbar",'height'=>90),							
			array("type"=>"glass",'border_height'=>15, 'border_width'=>15),	
			array("type"=>"crossbar",'height'=>130))
		),
		array("type"=>"pillar",'width'=>110)
	),

	"204"=>array(		
		array("type"=>"pillar",'width'=>110),	
		array("type"=>"container", 'value'=>array(
			array("type"=>"crossbar",'height'=>110),
			array("type"=>"filling",'border_height'=>15, 'border_width'=>15),
			array("type"=>"crossbar",'height'=>90),
			array("type"=>"filling",'border_height'=>15, 'border_width'=>15),
			array("type"=>"crossbar",'height'=>90),
			array("type"=>"filling",'border_height'=>15, 'border_width'=>15),
			array("type"=>"crossbar",'height'=>130))
		),
		array("type"=>"pillar",'width'=>110)
	),

	"301"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"glass",'border_height'=>15, 'border_width'=>15),
			array("type"=>"crossbar","height"=>305),
			array("type"=>"glass",'border_height'=>15, 'border_width'=>15),
			array("type"=>"crossbar","height"=>305),
			array("type"=>"glass",'border_height'=>15, 'border_width'=>15),
			array("type"=>"crossbar","height"=>305),
			array("type"=>"glass",'border_height'=>15, 'border_width'=>15),
			array("type"=>"crossbar","height"=>305),
			array("type"=>"glass",'border_height'=>15, 'border_width'=>15),
			array("type"=>"crossbar","height"=>305),
			array("type"=>"glass",'border_height'=>15, 'border_width'=>15),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110)
	),

	"302"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"filling",'border_height'=>15, 'border_width'=>15),
			array("type"=>"crossbar","height"=>305),
			array("type"=>"filling",'border_height'=>15, 'border_width'=>15),
			array("type"=>"crossbar","height"=>305),
			array("type"=>"filling",'border_height'=>15, 'border_width'=>15),
			array("type"=>"crossbar","height"=>305),
			array("type"=>"filling",'border_height'=>15, 'border_width'=>15),
			array("type"=>"crossbar","height"=>305),
			array("type"=>"filling",'border_height'=>15, 'border_width'=>15),
			array("type"=>"crossbar","height"=>305),
			array("type"=>"filling",'border_height'=>15, 'border_width'=>15),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110)
	),

	"401"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"container","value"=>array(
				array("type"=>"decor","width"=>30),
				array("type"=>"glass","border_height"=>15, "border_width"=>15),
				array("type"=>"decor","width"=>30)),
			),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110)
	),

	"402"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"container","value"=>array(
				array("type"=>"filling","border_height"=>15, "border_width"=>7),
				array("type"=>"decor","width"=>30),
				array("type"=>"glass","width"=>100,"border_height"=>15, "border_width"=>15),
				array("type"=>"decor","width"=>30),
				array("type"=>"filling","border_height"=>15, "border_width"=>7)),
			),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110)
	),

	"403"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"container","value"=>array(
				array("type"=>"decor","width"=>30),
				array("type"=>"filling","border_height"=>15, "border_width"=>15),
				array("type"=>"decor","width"=>30)),
			),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110)
	),

	"501"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"decor","height"=>30),
			array("type"=>"decor","height"=>30),
			array("type"=>"decor","height"=>30),
			array("type"=>"glass","border_height"=>15, "border_width"=>15),
			array("type"=>"decor","height"=>30),
			array("type"=>"decor","height"=>30),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110),
	),

	"502"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"decor","height"=>30),
			array("type"=>"decor","height"=>30),
			array("type"=>"decor","height"=>30),
			array("type"=>"filling","border_height"=>15, "border_width"=>15),
			array("type"=>"decor","height"=>30),
			array("type"=>"decor","height"=>30),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110),
	),

	"601"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"container","value"=>array(
				array("type"=>"filling","width"=>100,"border_height"=>15, "border_width"=>7),
				array("type"=>"glass","width"=>100,"border_height"=>15, "border_width"=>15),
				array("type"=>"filling","border_height"=>15, "border_width"=>7)),
			),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110)
	),

	"602"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"container","value"=>array(
				array("type"=>"filling","width"=>100,"border_height"=>15, "border_width"=>7),
				array("type"=>"glass","width"=>100,"border_height"=>15, "border_width"=>15),
				array("type"=>"filling","border_height"=>15, "border_width"=>7),
				array("type"=>"decor","width"=>30)),
			),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110)
	),

	"603"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"container","value"=>array(
				array("type"=>"filling","width"=>100,"border_height"=>15, "border_width"=>7),
				array("type"=>"glass","width"=>100,"border_height"=>15, "border_width"=>15),
				array("type"=>"filling","border_height"=>15, "border_width"=>7),
				array("type"=>"decor","width"=>30)),
			),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110)
	),

	"701"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"container","value"=>array(
				array("type"=>"filling","border_height"=>15, "border_width"=>7),
				array("type"=>"glass","width"=>100,"border_height"=>15, "border_width"=>15),
				array("type"=>"filling","border_height"=>15, "border_width"=>7)),
			),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110)
	),

	"702"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"container","value"=>array(
				array("type"=>"filling","border_height"=>15, "border_width"=>7),
				array("type"=>"decor","width"=>30),
				array("type"=>"filling","width"=>100,"border_height"=>15, "border_width"=>15),
				array("type"=>"filling","border_height"=>15, "border_width"=>7)),
			),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110)
	),

	"703"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"container","value"=>array(
				array("type"=>"filling","border_height"=>15, "border_width"=>7),
				array("type"=>"decor","width"=>30),
				array("type"=>"glass","width"=>100,"border_height"=>15, "border_width"=>15),
				array("type"=>"filling","border_height"=>15, "border_width"=>7)),
			),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110)
	),

	"801"=>array(		
		array("type"=>"pillar",'width'=>110),	
		array("type"=>"container", 'value'=>array(
			array("type"=>"crossbar",'height'=>110),
			array("type"=>"container", 'value'=>array(
				array("type"=>"glass",'border_height'=>15, 'border_width'=>15),
				array("type"=>"pillar",'width'=>90),							
				array("type"=>"glass",'border_height'=>15, 'border_width'=>15))
			),
			array("type"=>"crossbar",'height'=>130))
		),
		array("type"=>"pillar",'width'=>110)
	),

	"802"=>array(		
		array("type"=>"pillar",'width'=>110),	
		array("type"=>"container", 'value'=>array(
			array("type"=>"crossbar",'height'=>110),
			array("type"=>"container", 'value'=>array(
				array("type"=>"filling",'border_height'=>15, 'border_width'=>15),
				array("type"=>"pillar",'width'=>90),							
				array("type"=>"filling",'border_height'=>15, 'border_width'=>15))
			),	
			array("type"=>"crossbar",'height'=>130))
		),
		array("type"=>"pillar",'width'=>110)
	),

	"901"=>array(		
		array("type"=>"pillar",'width'=>110),	
		array("type"=>"glass",'border_width'=>15),
		array("type"=>"pillar",'width'=>110)
	),

	"902"=>array(		
		array("type"=>"pillar",'width'=>110),	
		array("type"=>"glass",'width'=>70, 'border_width'=>15),
		array("type"=>"pillar")
	),

	"1001"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"filling","height"=>150,'border_width'=>15),
			array("type"=>"glass",'border_height'=>15, 'border_width'=>15),
			array("type"=>"filling","height"=>150,'border_width'=>15),
			array("type"=>"filling","height"=>150,'border_width'=>15),
			array("type"=>"glass",'border_height'=>15, 'border_width'=>15),
			array("type"=>"filling","height"=>150,'border_width'=>15),
			array("type"=>"filling","height"=>150,'border_width'=>15),
			array("type"=>"glass",'border_height'=>15, 'border_width'=>15),
			array("type"=>"filling","height"=>150,'border_width'=>15),
			array("type"=>"filling","height"=>150,'border_width'=>15),
			array("type"=>"glass",'border_height'=>15, 'border_width'=>15),
			array("type"=>"filling","height"=>150,'border_width'=>15),
			array("type"=>"filling","height"=>150,'border_width'=>15),
			array("type"=>"glass",'border_height'=>15, 'border_width'=>15),
			array("type"=>"filling","height"=>150,'border_width'=>15),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110)
	),

	"1101"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"decor","height"=>60),
			array("type"=>"container","value"=>array(
				array("type"=>"decor","width"=>60),
				array("type"=>"glass","border_height"=>15, "border_width"=>15),
				array("type"=>"decor","width"=>60)),
			),
			array("type"=>"decor","height"=>60),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110),
	),

	"1102"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"decor","height"=>60),
			array("type"=>"container","value"=>array(
				array("type"=>"decor","width"=>60),
				array("type"=>"filling","border_height"=>15, "border_width"=>15),
				array("type"=>"decor","width"=>60)),
			),
			array("type"=>"decor","height"=>60),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110),
	),

	"1103"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"decor","height"=>60),
			array("type"=>"container","value"=>array(
				array("type"=>"decor","width"=>60),
				array("type"=>"container","value"=>array(
					array("type"=>"glass","border_height"=>15, "border_width"=>15))
				),
				array("type"=>"decor","width"=>60)),
			),
			array("type"=>"decor","height"=>60),
			array("type"=>"crossbar","height"=>110),
			array("type"=>"decor","height"=>60),
			array("type"=>"decor","width"=>60,"height"=>(750-130-110)),
			array("type"=>"filling","height"=>(750-130-110),"border_height"=>15, "border_width"=>15),
			array("type"=>"decor","width"=>60,"height"=>(750-130-110)),
			array("type"=>"decor","height"=>60),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110),
	),

	"1104"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"decor","height"=>60),
			array("type"=>"container","value"=>array(
				array("type"=>"decor","width"=>60),
				array("type"=>"container","value"=>array(
					array("type"=>"filling","border_height"=>15, "border_width"=>15))
				),
				array("type"=>"decor","width"=>60)),
			),
			array("type"=>"decor","height"=>60),
			array("type"=>"crossbar","height"=>110),
			array("type"=>"decor","height"=>60),
			array("type"=>"decor","width"=>60,"height"=>(750-130-110)),
			array("type"=>"filling","height"=>(750-130-110),"border_height"=>15, "border_width"=>15),
			array("type"=>"decor","width"=>60,"height"=>(750-130-110)),
			array("type"=>"decor","height"=>60),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110),
	),

	"1105"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"decor","height"=>60),
			array("type"=>"container","value"=>array(
				array("type"=>"decor","width"=>60),
				array("type"=>"container","value"=>array(
					array("type"=>"glass","border_height"=>15, "border_width"=>15))
				),
				array("type"=>"decor","width"=>60)),
			),
			array("type"=>"decor","height"=>60),
			array("type"=>"crossbar","height"=>110),
			array("type"=>"decor","height"=>60),
			array("type"=>"container","value"=>array(
				array("type"=>"decor","width"=>60),
				array("type"=>"container","value"=>array(
					array("type"=>"glass","border_height"=>15, "border_width"=>15))
				),
				array("type"=>"decor","width"=>60)),
			),
			array("type"=>"decor","height"=>60),
			array("type"=>"crossbar","height"=>110),
			array("type"=>"decor","height"=>60),
			array("type"=>"decor","width"=>60,"height"=>(750-130-110)),
			array("type"=>"glass","height"=>(750-130-110),"border_height"=>15, "border_width"=>15),
			array("type"=>"decor","width"=>60,"height"=>(750-130-110)),
			array("type"=>"decor","height"=>60),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110),
	),

	"1106"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"decor","height"=>60),
			array("type"=>"container","value"=>array(
				array("type"=>"decor","width"=>60),
				array("type"=>"container","value"=>array(
					array("type"=>"filling","border_height"=>15, "border_width"=>15))
				),
				array("type"=>"decor","width"=>60)),
			),
			array("type"=>"decor","height"=>60),
			array("type"=>"crossbar","height"=>110),
			array("type"=>"decor","height"=>60),
			array("type"=>"container","value"=>array(
				array("type"=>"decor","width"=>60),
				array("type"=>"container","value"=>array(
					array("type"=>"filling","border_height"=>15, "border_width"=>15))
				),
				array("type"=>"decor","width"=>60)),
			),
			array("type"=>"decor","height"=>60),
			array("type"=>"crossbar","height"=>110),
			array("type"=>"decor","height"=>60),
			array("type"=>"decor","width"=>60,"height"=>(750-130-110)),
			array("type"=>"filling","height"=>(750-130-110),"border_height"=>15, "border_width"=>15),
			array("type"=>"decor","width"=>60,"height"=>(750-130-110)),
			array("type"=>"decor","height"=>60),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110),
	),

	"1201"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"decor","height"=>60),
			array("type"=>"container","value"=>array(
				array("type"=>"decor","width"=>60),
				array("type"=>"container","value"=>array(
					array("type"=>"filling","border_height"=>15, "border_width"=>15))
				),
				array("type"=>"decor","width"=>60)),
			),
			array("type"=>"decor","height"=>60),
			array("type"=>"crossbar","height"=>110),
			array("type"=>"decor","height"=>60),
			array("type"=>"decor","width"=>60,"height"=>(750-130-110)),
			array("type"=>"filling","height"=>(750-130-110),"border_height"=>15, "border_width"=>15),
			array("type"=>"decor","width"=>60,"height"=>(750-130-110)),
			array("type"=>"decor","height"=>60),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110),
	),

	"1202"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"decor","height"=>60),
			array("type"=>"container","value"=>array(
				array("type"=>"decor","width"=>60),
				array("type"=>"container","value"=>array(
					array("type"=>"glass","border_height"=>15, "border_width"=>15))
				),
				array("type"=>"decor","width"=>60)),
			),
			array("type"=>"decor","height"=>60),
			array("type"=>"crossbar","height"=>110),
			array("type"=>"decor","height"=>60),
			array("type"=>"decor","width"=>60,"height"=>(750-130-110)),
			array("type"=>"filling","height"=>(750-130-110),"border_height"=>15, "border_width"=>15),
			array("type"=>"decor","width"=>60,"height"=>(750-130-110)),
			array("type"=>"decor","height"=>60),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110),
	),

	"1301"=>array(		
		array("type"=>"pillar"),
	),

	"1401"=>array(
		array("type"=>"pillar","width"=>110),
		array("type"=>"container","value"=>array(
			array("type"=>"crossbar","height"=>110),
			array("type"=>"container","value"=>array(
				array("type"=>"glass","border_height"=>15, "border_width"=>15),
				array("type"=>"filling","border_height"=>15),
				array("type"=>"filling","border_height"=>15),
				array("type"=>"glass","border_height"=>15, "border_width"=>15)),
			),
			array("type"=>"crossbar","height"=>130))
		),
		array("type"=>"pillar","width"=>110)
	),
);