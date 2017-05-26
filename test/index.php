<?php 
// include '../libs/SitemapGenerates/SitemapGenerate.php';
include '../libs/ProxyStreamingVideos/ProxyStreamingVideo.php';
include '../libs/Cookie/CookieObject.php';
include '../libs/GetLinkVideos/GetLinkVideo.php';
include '../libs/PathInfo.php';
// $sitemap = new SitemapGenerate('http://example.com');
// $sitemap->setPath('');
// $sitemap->addItem('/', '1.0', 'daily', 'Today');
// $sitemap->addItem('/about', '0.8', 'monthly', 'Jun 25');
// $sitemap->addItem('/contact', '0.6', 'yearly', '14-12-2009');
// // $sitemap->addItem('/otherpage');

// $sitemap->createSitemapIndex('http://example.com/sitemap/', 'Today');
use NptNguyen\Libs\GetLinkVideos\GetLinkVideo;
use NptNguyen\Libs\Cookie\CookieObject;

$get = new GetLinkVideo();
$get->getLinkZingTv('http://tv.zing.vn/video/Juushin-Enbu-Hero-Tales-Tap-1/IWZC6IUA.html');
var_dump($get->getSrcVideoJson());
exit;
$get->getLinkDriveUseProxy('https://drive.google.com/file/d/0B07Aof-8z6gRLS1sZVpUY3UxVkU/view');
$cc = $get->getCookie();
// var_dump($cc['data']['DRIVE_STREAM']);
$link = $get->getSrc360();
// var_dump($link);exit;
$coo = new CookieObject('DRIVE_STREAM', $cc['data']['DRIVE_STREAM'], '/', 'Session', '.drive.google.com');
// if(!empty($coo)){
// 	echo 'ohk';
// }

// exit;
$s = new NptNguyen\Libs\ProxyStreamingVideos\ProxyStreamingVideo($link, $coo);
$s->getStreamVideo();

 ?>