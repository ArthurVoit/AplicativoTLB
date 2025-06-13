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
const namedMeshes = {};
const loader = new GLTFLoader();
loader.load('../assets/3Dmodules/FLOREST.gltf',
    (gltf) => {

        gltf.scene.scale.set(102, 102, 102);

        scene.add(gltf.scene);
    }, undefined, (error) => {
        console.error('Error loading GLTF model:', error);
    });
//traintrack - 1 
loader.load('../assets/3Dmodules/trilhosDSelectable.gltf', (gltf) => {
    gltf.scene.scale.set(102, 102, 102);

    scene.add(gltf.scene);
}, undefined, (error) => {
    console.error('Error loading GLTF model:', error);
});

//train track - 2
loader.load('../assets/3Dmodules/trilhodSelectable.gltf', (gltf) => {
    gltf.scene.scale.set(102, 102, 102);

    scene.add(gltf.scene);
}, undefined, (error) => {
    console.error('Error loading GLTF model:', error);
});

//Turn1 button
loader.load('../assets/3Dmodules/T1B.gltf', (gltf) => {
    gltf.scene.scale.set(102, 102, 102);


    scene.add(gltf.scene);
}, undefined, (error) => {
    console.error('Error loading GLTF model:', error);
});


//Turn2 button
loader.load('../assets/3Dmodules/T2B.gltf', (gltf) => {
    gltf.scene.scale.set(102, 102, 102);
   scene.add(gltf.scene);
}, undefined, (error) => {
    console.error('Error loading GLTF model:', error);
});

//Switch Sides button
loader.load('../assets/3Dmodules/SSB.gltf', (gltf) => {
    gltf.scene.scale.set(102, 102, 102);

    scene.add(gltf.scene);
}, undefined, (error) => {
    console.error('Error loading GLTF model:', error);
});

const light = new THREE.AmbientLight(0xffffff, 1);

//interectability
const raycaster = new THREE.Raycaster();
renderer.domElement.addEventListener("click", onmousedown);

function onmousedown(event) {
    console.log("click confirmed")

    const coords = new THREE.Vector2(
        (event.clientX / window.innerWidth) * 2 - 1,
        -(event.clientY / window.innerHeight) * 2 + 1
    );
    raycaster.setFromCamera(coords, camera);

    const intersections = raycaster.intersectObjects(scene.children, true);

    //filter to only "Selectable" objects
    const selectable = intersections.filter(intersection => 
        intersection.object.name.includes("Selectable") );
   

    if (selectable.length > 0) {
        const selectedObject = selectable[0].object;
        console.log("Selected Object Name:", selectedObject.object.name);

        const color = new THREE.Color(0, 0, 1); // Blue

        if (selectedObject.material) {
            selectedObject.material.color.set(color);
        } else {
            selectedObject.traverse((child) => {
                if (child.isMesh && child.material) {
                    child.material.color.set(color);
                }
            });
        }
    }
}

scene.add(light);
scene.traverse((obj) => {
    if (obj.isMesh) console.log("Mesh found:", object.name);
});

function animate() {
    requestAnimationFrame(animate);
    renderer.render(scene, camera);
};
animate();