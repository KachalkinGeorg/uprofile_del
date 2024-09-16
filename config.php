<?php

if (!defined('NGCMS')) die ('HAL');

pluginsLoadConfig();
LoadPluginLang('uprofile_del', 'config', '', '', '#');

if (!getPluginStatusActive('uprofile')) {
	msg(['type' => 'error', 'text' => $lang['uprofile_del']['uprofile_error']]);
	return print_msg( 'warning', $lang['uprofile_del']['uprofile_del'], $lang['uprofile_del']['uprofile_error'], 'javascript:history.go(-1)' );
}

switch ($_REQUEST['action']) {
	case 'about':			about();		break;
	default: main();
}

function about()
{global $twig, $lang, $breadcrumb;
	$tpath = locatePluginTemplates(array('main', 'about'), 'uprofile_del', 1);
	$breadcrumb = breadcrumb('<i class="fa fa-user-times btn-position"></i><span class="text-semibold">'.$lang['uprofile_del']['uprofile_del'].'</span>', array('?mod=extras' => '<i class="fa fa-puzzle-piece btn-position"></i>'.$lang['extras'].'', '?mod=extra-config&plugin=uprofile_del' => '<i class="fa fa-user-times btn-position"></i>'.$lang['uprofile_del']['uprofile_del'].'',  '<i class="fa fa-exclamation-circle btn-position"></i>'.$lang['uprofile_del']['about'].'' ) );

	$xt = $twig->loadTemplate($tpath['about'].'about.tpl');
	$tVars = array();
	$xg = $twig->loadTemplate($tpath['main'].'main.tpl');
	
	$about = 'версия 0.2';
	
	$tVars = array(
		'global' => 'О плагине',
		'header' => $about,
		'entries' => $xt->render($tVars)
	);
	
	print $xg->render($tVars);
}

function main()
{global $twig, $lang, $breadcrumb;
	
	$tpath = locatePluginTemplates(array('main', 'general.from'), 'uprofile_del', 1);
	$breadcrumb = breadcrumb('<i class="fa fa-user-times btn-position"></i><span class="text-semibold">'.$lang['uprofile_del']['uprofile_del'].'</span>', array('?mod=extras' => '<i class="fa fa-puzzle-piece btn-position"></i>'.$lang['extras'].'', '?mod=extra-config&plugin=uprofile_del' => '<i class="fa fa-user-times btn-position"></i>'.$lang['uprofile_del']['uprofile_del'].'' ) );

	if (isset($_REQUEST['submit'])){
		pluginSetVariable('uprofile_del', 'notif_pm', intval($_REQUEST['notif_pm']));
		pluginSetVariable('uprofile_del', 'day_period', $_REQUEST['day_period']);
		pluginsSaveConfig();
		msg(array("type" => "info", "info" => "сохранение прошло успешно"));
		return print_msg( 'info', ''.$lang['uprofile_del']['uprofile_del'].'', 'Cохранение прошло успешно', 'javascript:history.go(-1)' );
	}
	
	$day_period = pluginGetVariable('uprofile_del', 'day_period');
	$notif_pm = pluginGetVariable('uprofile_del', 'notif_pm');
	$notif_pm = '<option value="0" '.($notif_pm==0?'selected':'').'>'.$lang['noa'].'</option><option value="1" '.($notif_pm==1?'selected':'').'>'.$lang['yesa'].'</option>';
	
	$xt = $twig->loadTemplate($tpath['general.from'].'general.from.tpl');
	$xg = $twig->loadTemplate($tpath['main'].'main.tpl');
	
	$tVars = array(
		'notif_pm' => $notif_pm,
		'day_period' => $day_period,
	);
	
	$tVars = array(
		'global' => 'Общие',
		'header' => '<i class="fa fa-exclamation-circle"></i> <a href="?mod=extra-config&plugin=uprofile_del&action=about">'.$lang['uprofile_del']['about'].'</a>',
		'entries' => $xt->render($tVars)
	);
	
	print $xg->render($tVars);
}

?>