//import area
import * as THREE from 'https://cdn.jsdelivr.net/npm/three@0.177.0/build/three.module.min.js';
import { GLTFLoader } from 'https://cdn.jsdelivr.net/npm/three@0.177.0/examples/jsm/loaders/GLTFLoader.js';

const scene = new THREE.Scene();


let camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 100);
camera.position.set(-0, 0, 14);

const canvas = document.querySelector('#map');
const renderer = new THREE.WebGLRenderer({ antialias: true, canvas });
renderer.setSize(window.innerWidth, window.innerHeight);
document.body.appendChild(renderer.domElement);


//loaded mesh

//main area
const loader = new GLTFLoader();
const namedMeshes = {};
loader.load('../assets/3D modules/FLOREST.gltf',
     (gltf) => {
    gltf.scene.scale.set(102, 102, 102);
    gltf.scene.traverse((child) => {
        if (child.isMesh) {
            namedMeshes[child.name] = child; 
        }
    });
    scene.add(gltf.scene);
}, undefined, (error) => {
    console.error('Error loading GLTF model:', error);
});

loader.load('../assets/3D modules/trilhosD.gltf', (gltf) => {
    gltf.scene.scale.set(102, 102, 102);
    gltf.scene.traverse((child) => {
        if (child.isMesh) {
            namedMeshes[child.name] = child; 
        }
    });

    scene.add(gltf.scene);
}, undefined, (error) => {
    console.error('Error loading GLTF model:', error);
});

//trail -d 
loader.load('../assets/3D modules/trilhod.gltf', (gltf) => {
    gltf.scene.scale.set(102, 102, 102);
    gltf.scene.traverse((child) => {
        if (child.isMesh) {
            namedMeshes[child.name] = child; 
        }
    });

    scene.add(gltf.scene);
}, undefined, (error) => {
    console.error('Error loading GLTF model:', error);
});

//Turn1 button
loader.load('../assets/3D modules/T1B.gltf', (gltf) => {
    gltf.scene.scale.set(102, 102, 102);
    gltf.scene.traverse((child) => {
        if (child.isMesh) {
            namedMeshes[child.name] = child; 
        }
    });
    scene.add(gltf.scene);
}, undefined, (error) => {
    console.error('Error loading GLTF model:', error);
});


//Turn2 button
loader.load('../assets/3D modules/T2B.gltf', (gltf) => {
    gltf.scene.scale.set(102, 102, 102);
    gltf.scene.traverse((child) => {
        if (child.isMesh) {
            namedMeshes[child.name] = child; 
        }
    });
    scene.add(gltf.scene);
}, undefined, (error) => {
    console.error('Error loading GLTF model:', error);
});

//Switch Sides button
loader.load('../assets/3D modules/SSB.gltf', (gltf) => {
    gltf.scene.scale.set(102, 102, 102);
    gltf.scene.traverse((child) => {
        if (child.isMesh) {
            namedMeshes[child.name] = child; 
        }
    });
    scene.add(gltf.scene);
}, undefined, (error) => {
    console.error('Error loading GLTF model:', error);
});

const light = new THREE.AmbientLight(0xffffff, 1);

//interectability
const raycaster = new THREE.Raycaster(); 
renderer.domElement.addEventListener("click", onmousedown);

function onmousedown(event){
    console.log("click confirmed")
    
    const coords = new THREE.Vector2(
        (event.clientX / window.innerWidth) * 2 - 1,
        -(event.clientY / window.innerHeight) * 2 + 1 
    );
    raycaster.setFromCamera(coords, camera);
    const selectable = [] 
      selectable.push("trilhod","trilhoD") ;
      raycaster.intersectObjects(selectable , true);

    const intersections = raycaster.intersectObjects(scene.children, true);
    if (intersections.length > 0) {
        const selectedObject = intersections[0].object;
        const color = new THREE.Color(0, 0, 1); 
    
        if (selectedObject.material) {
            selectedObject.material.color.set(0,0,1);
        } else if (selectedObject.parent) {
            selectedObject.parent.traverse((child) => {
                if (child.isMesh) child.material.color.set(color);
            });
        }
    }
};

scene.add(light);

function animate() {
    requestAnimationFrame(animate);
    renderer.render(scene, camera);
};
animate();