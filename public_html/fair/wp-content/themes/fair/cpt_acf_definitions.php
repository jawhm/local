<?php
/*
 * This file is custom post type, custom taxonomy and custom fields
 * definition file.
 * 
 * Exported from CPT UI & Advanced Custom Fields
 */

//post type definitions
add_action( 'init', 'cptui_register_my_cpts' );
function cptui_register_my_cpts() {
	$labels = array(
		"name" => "ポイント",
		"singular_name" => "ポイント",
		);

	$args = array(
		"labels" => $labels,
		"description" => "トップのポイント",
		"public" => true,
		"show_ui" => true,
		"has_archive" => false,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "point", "with_front" => true ),
		"query_var" => true,
				
		"supports" => array( "title" ),		
	);
	register_post_type( "point", $args );

	$labels = array(
		"name" => "参加者の声",
		"singular_name" => "参加者の声",
		);

	$args = array(
		"labels" => $labels,
		"description" => "セミナー参加者の声",
		"public" => true,
		"show_ui" => true,
		"has_archive" => false,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "voice", "with_front" => true ),
		"query_var" => true,
				
		"supports" => array( "title" ),		
	);
	register_post_type( "voice", $args );

	$labels = array(
		"name" => "セミナー種類",
		"singular_name" => "セミナー種類",
		);

	$args = array(
		"labels" => $labels,
		"description" => "掲載するセミナーの種類です",
		"public" => true,
		"show_ui" => true,
		"has_archive" => false,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "seminar", "with_front" => true ),
		"query_var" => true,
				
		"supports" => array( "title" ),		
	);
	register_post_type( "seminar", $args );

	$labels = array(
		"name" => "よくある質問",
		"singular_name" => "よくある質問",
		);

	$args = array(
		"labels" => $labels,
		"description" => "よくある質問です",
		"public" => true,
		"show_ui" => true,
		"has_archive" => false,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "question", "with_front" => true ),
		"query_var" => true,
				
		"supports" => array( "title" ),		
	);
	register_post_type( "question", $args );

	$labels = array(
		"name" => "語学学校",
		"singular_name" => "語学学校",
		);

	$args = array(
		"labels" => $labels,
		"description" => "語学学校の説明を記述します",
		"public" => true,
		"show_ui" => true,
		"has_archive" => false,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "school", "with_front" => true ),
		"query_var" => true,
				
		"supports" => array( "title" ),		
	);
	register_post_type( "school", $args );

// End of cptui_register_my_cpts()
}

//taxonomy definitions
add_action( 'init', 'cptui_register_my_taxes' );
function cptui_register_my_taxes() {

	$labels = array(
		"name" => "国",
		"label" => "国",
		);

	$args = array(
		"labels" => $labels,
		"hierarchical" => true,
		"label" => "国",
		"show_ui" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'country', 'with_front' => true ),
		"show_admin_column" => false,
	);
	register_taxonomy( "country", array( "school" ), $args );

// End cptui_register_my_taxes
}

//custom fields definitions
if(function_exists("register_field_group"))
{
        register_field_group(array (
		'id' => 'acf_point',
		'title' => 'point',
		'fields' => array (
			array (
				'key' => 'field_558110678cdb5',
				'label' => '+more説明文',
				'name' => 'text',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'br',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'point',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
        
	register_field_group(array (
		'id' => 'acf_question',
		'title' => 'question',
		'fields' => array (
			array (
				'key' => 'field_557f913aed099',
				'label' => '質問',
				'name' => 'question',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_557f91d1a9819',
				'label' => '回答見出し',
				'name' => 'caption',
				'type' => 'text',
				'instructions' => '赤字で表示されます',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_557f9148ed09a',
				'label' => '回答',
				'name' => 'answer',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'br',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'question',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_school',
		'title' => 'school',
		'fields' => array (
			array (
				'key' => 'field_557f95b8be8b7',
				'label' => '学校名ルビ',
				'name' => 'rubi',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_557f960bbe8b8',
				'label' => 'キャッチフレーズ',
				'name' => 'catchphrase',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_557f9663be8b9',
				'label' => '学校ロゴ',
				'name' => 'logo',
				'type' => 'image',
				'save_format' => 'url',
				'preview_size' => 'full',
				'library' => 'all',
			),
			array (
				'key' => 'field_557f967abe8ba',
				'label' => '学校紹介画像',
				'name' => 'image',
				'type' => 'image',
				'instructions' => '詳細画面で表示される画像です',
				'save_format' => 'url',
				'preview_size' => 'full',
				'library' => 'all',
			),
			array (
				'key' => 'field_557f969dbe8bb',
				'label' => '現地スタッフからのコメント',
				'name' => 'staff_comment',
				'type' => 'wysiwyg',
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),
			array (
				'key' => 'field_557f96e2be8bc',
				'label' => '現地スタッフ紹介画像',
				'name' => 'staff_image',
				'type' => 'image',
				'save_format' => 'object',
				'preview_size' => 'full',
				'library' => 'all',
			),
			array (
				'key' => 'field_557f96fabe8bd',
				'label' => '語学学校の特徴',
				'name' => 'features',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_557f9739be8be',
						'label' => '特徴見出し',
						'name' => 'caption',
						'type' => 'text',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_557f974dbe8bf',
						'label' => '特徴説明文',
						'name' => 'text',
						'type' => 'text',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => '特徴追加',
			),
			array (
				'key' => 'field_557f9877cd888',
				'label' => 'テーマカラー',
				'name' => 'color',
				'type' => 'color_picker',
				'required' => 1,
				'default_value' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'school',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_seminar',
		'title' => 'seminar',
		'fields' => array (
			array (
				'key' => 'field_557f8f074e168',
				'label' => '画像',
				'name' => 'image',
				'type' => 'image',
				'save_format' => 'url',
				'preview_size' => 'full',
				'library' => 'all',
			),
			array (
				'key' => 'field_557f8d079864e',
				'label' => '説明文',
				'name' => 'description',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_557f8d369864f',
				'label' => 'セミナーのポイント',
				'name' => 'points',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_557f8d5898650',
						'label' => 'ポイント説明分',
						'name' => 'point',
						'type' => 'text',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Add Row',
			),
			array (
				'key' => 'field_557f8d7198651',
				'label' => 'テーマカラー',
				'name' => 'color',
				'type' => 'color_picker',
				'required' => 1,
				'default_value' => '',
			),
                        array (
                                'key' => 'field_5581247b5f4e3',
                                'label' => 'アイコン',
                                'name' => 'icon',
                                'type' => 'image',
                                'save_format' => 'url',
                                'preview_size' => 'full',
                                'library' => 'all',
                        ),
			array (
				'key' => 'field_557f9025f2e95',
				'label' => 'セミナー検索用キーワード',
				'name' => 'keyword',
				'type' => 'text',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'seminar',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_voice',
		'title' => 'voice',
		'fields' => array (
			array (
				'key' => 'field_557f8ac0f0a5e',
				'label' => '本文',
				'name' => 'body',
				'type' => 'textarea',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_557f8ae2f0a5f',
				'label' => 'プロフィール',
				'name' => 'profile',
				'type' => 'text',
				'instructions' => '参加者のプロフィール',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '26歳　女性　美容師',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_557f9a073bae6',
				'label' => '参加者の写真',
				'name' => 'image',
				'type' => 'image',
				'save_format' => 'url',
				'preview_size' => 'full',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'voice',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
