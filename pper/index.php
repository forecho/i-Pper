﻿<!DOCTYPE HTML>
<!DOCTYPE html PUBLIC "" "">
<HTML>
<HEAD>
<META content="IE=11.0000" 
http-equiv="X-UA-Compatible">
		 
<META charset="utf-8">		 
<META name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<TITLE>快拍客</TITLE>		 
<STYLE>
			html, body {
				height: 100%;
			}

			body {
				background-color: #000000;
				margin: 0;
				font-family: Arial;
				overflow: hidden;
			}

			a {
				color: #ffffff;
			}

			#info {
				position: absolute;
				width: 100%;
				color: #ffffff;
				padding: 5px;
				font-family: Monospace;
				font-size: 13px;
				font-weight: bold;
				text-align: center;
			}

			#menu {
				position: absolute;
				bottom: 20px;
				width: 100%;
				text-align: center;
			}

			.element {
				width: 120px;
				height: 160px;
				box-shadow: 0px 0px 12px rgba(0,255,255,0.5);
				border: 1px solid rgba(127,255,255,0.25);

				cursor: default;
			}

			.element:hover {
				box-shadow: 0px 0px 12px rgba(0,255,255,0.75);
				border: 1px solid rgba(127,255,255,0.75);
			}
				
				.element img {
					position: absolute;
					border:none;
				}
				
				.element .number {
					position: absolute;
					top: 20px;
					right: 20px;
					font-size: 12px;
					color: rgba(127,255,255,0.75);
				}

				.element .symbol {
					position: absolute;
					top: 40px;
					left: 0px;
					right: 0px;
					font-size: 60px;
					font-weight: bold;
					color: rgba(255,255,255,0.75);
					text-shadow: 0 0 10px rgba(0,255,255,0.95);
				}

				.element .details {
					position: absolute;
					bottom: 15px;
					left: 0px;
					right: 0px;
					font-size: 12px;
					color: rgba(127,255,255,0.75);
				}
				
			button {
				color: rgba(127,255,255,0.75);
				background: transparent;
				outline: 1px solid rgba(127,255,255,0.75);
				border: 0px;
				padding: 5px 10px;
				cursor: pointer;
			}
			button:hover {
				background-color: rgba(0,255,255,0.5);
			}
			button:active {
				color: #000000;
				background-color: rgba(0,255,255,0.75);
			}
		</STYLE>
	 
<META name="GENERATOR" content="MSHTML 11.00.9600.16476">

<?php
	$dir = "photoResize";
	$dh = opendir('./'.$dir); //当前目录
	$i = 0;
	$files = array();
	//$file
	while (false !== ($file = readdir($dh)) && $i < 108) { //遍历该php文件所在目录
		list($filesname,$kzm)=explode(".",$file);//获取扩展名
		if($kzm=="gif" or $kzm=="jpg" or $kzm=="JPG" or $kzm=="png" or $kzm=="PNG") { //文件过滤
		  if (!is_dir("./".$file)) { //文件夹过滤
			$files[$i]["name"] = $file;//获取文件名称
			$files[$i]["size"] = round((filesize($dir .'/'.$file)/1024),2);//获取文件大小
			$files[$i]["time"] = date("Y-m-d H:i:s",filemtime($dir .'/'.$file));//获取文件最近修改日期
			$i++;//记录图片总张数
		   }
		  }
	}
    closedir($dh);

    foreach($files as $k=>$v){
        $size[$k] = $v['size'];
        $time[$k] = $v['time'];
        $name[$k] = $v['name'];
    }

    array_multisort($time,SORT_DESC,SORT_STRING, $files);//按时间排序
?>

	<link href="css/lightbox.css" rel="stylesheet" />
</HEAD>	 
<BODY>
	
<script src="js/jquery-1.10.2.min.js"></script>

<script src="js/lightbox-2.6.min.js"></script>
	
<SCRIPT src="js/three.min.js"></SCRIPT>
		 
<SCRIPT src="js/tween.min.js"></SCRIPT>
		 
<SCRIPT src="js/TrackballControls.js"></SCRIPT>
		 
<SCRIPT src="js/CSS3DRenderer.js"></SCRIPT>
		 
<DIV id="container"></DIV>
<DIV id="info">
	我们不是摄影师，我们也不懂美工，我们只是喜欢随手拍拍而已。我们是————<font size="5" color="red">快拍客！</font>
</DIV>
<div>
	<img src='img/weixin.jpg' width = '110px',height = '110px'></br>
	<A href="http://www.kper.com.cn" target="_blank"><h1>快拍客</h1></A>
	<font size="1" color="red">微信添加公共账号，发送图片</br>刷新！你的照片上墙了</font>

</div>

<DIV id="menu">
	<BUTTON id="table">单页墙</BUTTON>
	<BUTTON id="sphere">球形墙</BUTTON>
	<BUTTON id="helix">螺旋墙</BUTTON>
	<BUTTON id="grid">矩阵墙</BUTTON>
			 
<SCRIPT>
			//单页墙w18*h9
			var table = [];
			
			var camera, scene, renderer;
			var controls;

			var objects = [];
			var targets = { table: [], sphere: [], helix: [], grid: [] };
			
			getImgs();
			init();
			animate();

			function init() {

				camera = new THREE.PerspectiveCamera( 40, window.innerWidth / window.innerHeight, 1, 10000 );
				camera.position.z = 3000;

				scene = new THREE.Scene();
				
				
				for ( var i = 0; i < table.length; i ++ ) {

					var element = document.createElement( 'div' );
					element.className = 'element';
					element.style.backgroundColor = 'rgba(0,127,127,' + ( Math.random() * 0.5 + 0.25 ) + ')';

					var a = document.createElement('a');
					a.href =  'photo/' + table[ i ][0];
					a.setAttribute('data-lightbox','roadtrip');
					a.setAttribute('title',a.href.substr(a.href.lastIndexOf('/')+1));
//					a.setAttribute('text-align','center');
					
					var image=new Image();
					image.src='photoResize/'+table[ i ][0];
					a.appendChild(image)
					
					element.appendChild( a );

					var object = new THREE.CSS3DObject( element );
					object.position.x = Math.random() * 4000 - 2000;
					object.position.y = Math.random() * 4000 - 2000;
					object.position.z = Math.random() * 4000 - 2000;
					scene.add( object );

					objects.push( object );

					var object = new THREE.Object3D();
					object.position.x = ( table[ i ] [1] * 140 ) - 1330;
					object.position.y = - ( table[ i ] [2]* 180 ) + 990;
					targets.table.push( object );					

					image.addEventListener('load',function(event)
					{
						resizeImg(this,120,160);
					},false);

				}

				// sphere 球形墙

				var vector = new THREE.Vector3();

				for ( var i = 0, l = objects.length; i < l; i ++ ) {

					var phi = Math.acos( -1 + ( 2 * i ) / l );
					var theta = Math.sqrt( l * Math.PI ) * phi;

					var object = new THREE.Object3D();

					object.position.x = 800 * Math.cos( theta ) * Math.sin( phi );
					object.position.y = 800 * Math.sin( theta ) * Math.sin( phi );
					object.position.z = 800 * Math.cos( phi );

					vector.copy( object.position ).multiplyScalar( 2 );

					object.lookAt( vector );

					targets.sphere.push( object );

				}

				// helix 螺旋墙

				var vector = new THREE.Vector3();

				for ( var i = 0, l = objects.length; i < l; i ++ ) {

					var phi = i * 0.175 + Math.PI;

					var object = new THREE.Object3D();

					object.position.x = 900 * Math.sin( phi );
					object.position.y = - ( i * 8 ) + 450;
					object.position.z = 900 * Math.cos( phi );

					vector.x = object.position.x * 2;
					vector.y = object.position.y;
					vector.z = object.position.z * 2;

					object.lookAt( vector );

					targets.helix.push( object );

				}

				// grid 矩阵墙

				for ( var i = 0; i < objects.length; i ++ ) {

					var object = new THREE.Object3D();

					object.position.x = ( ( i % 5 ) * 400 ) - 800;
					object.position.y = ( - ( Math.floor( i / 5 ) % 5 ) * 400 ) + 800;
					object.position.z = ( Math.floor( i / 25 ) ) * 1000 - 2000;

					targets.grid.push( object );

				}

				//

				renderer = new THREE.CSS3DRenderer();
				renderer.setSize( window.innerWidth, window.innerHeight );
				renderer.domElement.style.position = 'absolute';
				document.getElementById( 'container' ).appendChild( renderer.domElement );

				//

				controls = new THREE.TrackballControls( camera, renderer.domElement );
				controls.rotateSpeed = 0.5;
				controls.minDistance = 500;
				controls.maxDistance = 6000;
				controls.addEventListener( 'change', render );

				var button = document.getElementById( 'table' );
				button.addEventListener( 'click', function ( event ) {

					transform( targets.table, 2000 );

				}, false );

				var button = document.getElementById( 'sphere' );
				button.addEventListener( 'click', function ( event ) {

					transform( targets.sphere, 2000 );

				}, false );

				var button = document.getElementById( 'helix' );
				button.addEventListener( 'click', function ( event ) {

					transform( targets.helix, 2000 );

				}, false );

				var button = document.getElementById( 'grid' );
				button.addEventListener( 'click', function ( event ) {

					transform( targets.grid, 2000 );

				}, false );

				//transform( targets.table, 5000 );
				transform( targets.helix, 2000 );
				//

				window.addEventListener( 'resize', onWindowResize, false );

			}

			function transform( targets, duration ) {

				TWEEN.removeAll();

				for ( var i = 0; i < objects.length; i ++ ) {

					var object = objects[ i ];
					var target = targets[ i ];

					new TWEEN.Tween( object.position )
						.to( { x: target.position.x, y: target.position.y, z: target.position.z }, Math.random() * duration + duration )
						.easing( TWEEN.Easing.Exponential.InOut )
						.start();

					new TWEEN.Tween( object.rotation )
						.to( { x: target.rotation.x, y: target.rotation.y, z: target.rotation.z }, Math.random() * duration + duration )
						.easing( TWEEN.Easing.Exponential.InOut )
						.start();

				}

				new TWEEN.Tween( this )
					.to( {}, duration * 2 )
					.onUpdate( render )
					.start();

			}

			function onWindowResize() {

				camera.aspect = window.innerWidth / window.innerHeight;
				camera.updateProjectionMatrix();

				renderer.setSize( window.innerWidth, window.innerHeight );

			}

			function animate() {

				requestAnimationFrame( animate );

				TWEEN.update();
				controls.update();


			}

			function render() {

				renderer.render( scene, camera );

			}

			// 说明：用 JavaScript 实现网页图片等比例缩放 
			function resizeImg(image,distWidth,distHeight) 
			{ 
				srcWidth = image.width;
				srcHeight = image.height;
				var ratio = 1;
				if(srcWidth>0 && srcHeight>0) 
				{ 
					if(srcWidth/srcHeight>= distWidth/distHeight) 
					{ 
						if(srcWidth>distWidth) 
						{ 
							ratio = distWidth/srcWidth; 
						} 
					} 
					else 
					{ 
						if(srcHeight>distHeight) 
						{ 
							ratio = distHeight/srcHeight; 
						} 
					} 
				} 
				var width = srcWidth*ratio;
				var heigh = srcHeight*ratio;
				
				image.style.width = width.toString() + 'px';
				image.style.height = heigh.toString() + 'px';

				if(width < distWidth)
					image.style.paddingLeft = ((distWidth - width)/2).toString() + 'px';
					
				if(heigh < distHeight)
					image.style.paddingTop = ((distHeight - heigh)/2).toString() + 'px';
			} 	
			
			//获得指定文件夹图片名称列表
			function getImgs (){
				var arrfiles = <?php echo json_encode($files);?>;
				var row =1;
				var col = 1;
				for(var i = 0; i < arrfiles.length;i++)
				{
					var file = [];
					file[0] = arrfiles[i]['name'];
					file[1] = col++;
					file[2] = row;
					table[i] = file;
					if(col > 18)
					{
						col = 1;
						row++;
					}
				}	
			}

		
		</SCRIPT>
	 </DIV>
 </BODY>
</HTML>