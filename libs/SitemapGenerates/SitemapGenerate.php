<?php 
namespace NptNguyen\Libs\SitemapGenerates;

/**
* sitemap generate
* http://www.pontikis.net/blog/creating-dynamic-xml-sitemaps-using-php
* chua xong
*/
class SitemapGenerate
{
	private $domain = null;
	private $protocol = null;
	private $changefreg = null; //always, hourly, daily, weekly, monthly, yearly, never
	private $priority = null;
	//
	private $url = null;
	private $lastmod = null;
	
	function __construct($protocol = 'http', $domain = '', $url = '', $changefreg = 'never')
	{
		$this->protocol = $protocol;
		$this->domain = $domain;
		$this->changefreg = $changefreg;
		$this->protocol = $protocol;

	}

	public function ab(){
		header('Content-type: application/xml');
		
	}
	public function getSitemapIndexXML(){
		header('Content-type: application/xml');
		echo '<?xml version="1.0" encoding="UTF-8"?>';
		?>
		<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
		  <sitemap>
		    <loc>http://www.pontikis.net/sitemap-main.xml</loc>
		  </sitemap>
		  <sitemap>
		    <loc>http://www.pontikis.net/blog/sitemap.php</loc>
		  </sitemap>
		  <sitemap>
		    <loc>http://www.pontikis.net/labs/sitemap-labs.xml</loc>
		  </sitemap>
		  <sitemap>
		    <loc>http://www.pontikis.net/bbs/sitemap.php</loc>
		  </sitemap>
		</sitemapindex>

		<?php
	}
	public function getSitemap(){
		header('Content-type: application/xml');
		echo '<?xml version="1.0" encoding="UTF-8"?>';
		?>
		<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
		  	<url>
				<loc>http://www.pontikis.net/</loc>
				<lastmod>2013-03-09T20:00:00+00:00</lastmod>
				<changefreq>daily</changefreq>
			</url>
		</urlset>

		<?php
	}
}


 ?>