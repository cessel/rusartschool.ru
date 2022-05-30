<?
/*
Template Name: Страница расписания
*/

get_header('new');


$class_groups = get_field('class_group');


?>
<div class="timetable">
    <div class='container'>
        <h1><?=get_the_title($post->ID); ?></h1>
        <?



        foreach ( $class_groups as $class_group ) {
            ?>
                <div class="class-group">
                    <div class="class-group__inner">
                        <div class="class-group__name js--show-class-group">
                            <?=$class_group['class_group_name'];?>
                        </div>
                        <div class="class-group__content">
                            <?
                            $classes = $class_group['class'];
                            foreach ( $classes as $class ) {
                                ?>
                                <div class="class">
                                    <div class="class__inner">
                                        <div class="class__name js--show-class">
				                            <?=$class['class_name'];?>
                                        </div>
                                        <div class="class__content">
				                            <?
                                            $week_days = $class['week_day'];
				                            foreach ( $week_days as $week_day ) {
                                                ?>
                                                <div class="week_day">
                                                    <div class="week_day__inner">
                                                        <div class="week_day__name">
								                            <?=$week_day['day_name'];?>
                                                        </div>
                                                        <div class="week_day__content">
                                                            <div class="lesson-header">
                                                                <div class="lesson__inner">
                                                                    <div class="lesson__name">
				                                                        Урок
                                                                    </div>
                                                                    <div class="lesson__start">
				                                                        Начало и окончание
                                                                    </div>
                                                                    <? /*
                                                                    <div class="lesson__end">
				                                                        Окончание
                                                                    </div>
                                                                    */ ?>
                                                                    <div class="lesson__delay">
				                                                        Преподаватель
                                                                    </div>
                                                                </div>
                                                            </div>
								                            <?
                                                            $lessons = $week_day['lessons'];
								                            foreach ( $lessons as $lesson ) {
									                            ?>
                                                                <div class="lesson">
                                                                    <div class="lesson__inner">
                                                                        <div class="lesson__name">
		                                                                    <?=$lesson['lesson_name'];?>
                                                                        </div>

                                                                        <div class="lesson__start">
		                                                                    <?=$lesson['lesson_start']; ?>
                                                                        </div>
                                                                        <? /*
                                                                        <div class="lesson__end">
		                                                                    <?=$lesson['lesson_end']; ?>
                                                                        </div>
                                                                        */ ?>
                                                                        <div class="lesson__delay">
		                                                                    <?=$lesson['lesson_delay']; ?>
                                                                        </div>

                                                                    </div>
                                                                </div>
									                            <?
								                            }
								                            ?>
                                                        </div>
                                                    </div>
                                                </div>
					                            <?
				                            }
				                            ?>
                                        </div>
                                    </div>
                                </div>


	                            <?
                            }
                            ?>

                        </div>
                    </div>
                </div>
            <?
            }
        echo apply_filters('the_content',$post->post_content);
        ?>
    </div>
</div>
<?php get_footer(); ?>