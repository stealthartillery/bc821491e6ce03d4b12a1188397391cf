	var scene = new THREE.Scene();
	scene.background = new THREE.Color( 0xffffff );
	var gltfLoader = new THREE.GLTFLoader();

	var camera = new THREE.PerspectiveCamera( 75, window.innerWidth/window.innerHeight, 0.1, 1000 );
	// camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 1, 10000 );


	var light = new THREE.AmbientLight( 0xffffff, 0.5 ); // soft white light
	// var light = new THREE.AmbientLight( 0x404040 ); // soft white light
	scene.add( light );

	light_direction = new THREE.DirectionalLight( 0xffffff , 0.6);
	light_direction.position.set( 1, 1, 1);
	// light_direction.position.set( 0, 20, 10 );
	scene.add( light_direction );

	light_direction = new THREE.DirectionalLight( 0xffffff , 0.6);
	light_direction.position.set( 1, 1, -1 );
	// light_direction.position.set( 0, 20, 10 );
	scene.add( light_direction );

	light_direction = new THREE.DirectionalLight( 0xffffff , 0.6);
	light_direction.position.set( -1, 1, 1 );
	// light_direction.position.set( 0, 20, 10 );
	scene.add( light_direction );

	light_direction = new THREE.DirectionalLight( 0xffffff , 0.6);
	light_direction.position.set( -1, 1, -1 );
	// light_direction.position.set( 0, 20, 10 );
	scene.add( light_direction );


	gltfLoader.load('obj/fountain/obj.gltf', function (gltf) {
	    ground_mesh = gltf.scene;
	    ground_mesh.position.x = 0;
	    ground_mesh.position.y = 0;
	    ground_mesh.position.z = 0;
	    ground_mesh.scale.set(5,5,5);
	    scene.add(ground_mesh);		
	});

	camera.position.x = 100
	camera.position.y = 100
	camera.position.z = 100
  	camera.lookAt(scene.position)

	// Create a renderer with Antialiasing
	var renderer = new THREE.WebGLRenderer({antialias:true});

	// Configure renderer clear color
	renderer.setClearColor("#000000");

	// Configure renderer size
	renderer.setSize( window.innerWidth, window.innerHeight );

	// Append Renderer to DOM
	document.body.appendChild( renderer.domElement );

	// Render Loop
	var render = function () {
	  // requestAnimationFrame( render );
		// Your animated code goes here
		renderer.render(scene, camera);
	};

	animate()

	function animate() {
		requestAnimationFrame(animate);
		render();
	}