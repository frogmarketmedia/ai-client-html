<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2014
 * @copyright Aimeos (aimeos.org), 2015-2020
 */


namespace Aimeos\Client\Html\Catalog\Stage\Navigator;


class StandardTest extends \PHPUnit\Framework\TestCase
{
	private $object;


	protected function setUp() : void
	{
		$context = \TestHelperHtml::getContext();
		$paths = \TestHelperHtml::getHtmlTemplatePaths();
		$this->object = new \Aimeos\Client\Html\Catalog\Stage\Navigator\Standard( $context, $paths );
		$this->object->setView( \TestHelperHtml::getView() );
	}


	protected function tearDown() : void
	{
		unset( $this->object );
	}


	public function testGetBody()
	{
		$view = $this->object->getView();
		$helper = new \Aimeos\MW\View\Helper\Param\Standard( $view, array( 'd_pos' => 1 ) );
		$view->addHelper( 'param', $helper );

		$view->navigationPrev = '#';
		$view->navigationNext = '#';

		$this->object->setView( $this->object->addData( $view ) );
		$output = $this->object->getBody();

		$this->assertStringStartsWith( '<!-- catalog.stage.navigator -->', $output );
		$this->assertStringContainsString( '<a class="prev"', $output );
		$this->assertStringContainsString( '<a class="next"', $output );
	}


	public function testModifyHeader()
	{
		$view = $this->object->getView();
		$helper = new \Aimeos\MW\View\Helper\Param\Standard( $view, array( 'd_pos' => 1 ) );
		$view->addHelper( 'param', $helper );

		$content = '<!-- catalog.stage.navigator -->test<!-- catalog.stage.navigator -->';
		$output = $this->object->modifyHeader( $content, 1 );

		$this->assertStringContainsString( '<!-- catalog.stage.navigator -->', $output );
	}


	public function testModifyBody()
	{
		$view = $this->object->getView();
		$helper = new \Aimeos\MW\View\Helper\Param\Standard( $view, array( 'd_pos' => 1 ) );
		$view->addHelper( 'param', $helper );

		$content = '<!-- catalog.stage.navigator -->test<!-- catalog.stage.navigator -->';
		$output = $this->object->modifyBody( $content, 1 );

		$this->assertStringContainsString( '<div class="catalog-stage-navigator">', $output );
	}


	public function testGetSubClient()
	{
		$this->expectException( '\\Aimeos\\Client\\Html\\Exception' );
		$this->object->getSubClient( 'invalid', 'invalid' );
	}
}
