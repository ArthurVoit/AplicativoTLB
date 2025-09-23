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
const geometry = new THREE.PlaneGeometry(2, 2); // width and height
const material = new THREE.MeshBasicMaterial({ color: 0x00ff00, side: THREE.DoubleSide });
const square = new THREE.Mesh(geometry, material);
scene.add(square);


loader.load('../assets/3Dmodules/trilhosDSelectable.gltf', (gltf) => {
    gltf.scene.scale.set(102, 102, 102);

    scene.add(gltf.scene);
}, undefined, (error) => {
    console.error('Error loading GLTF model:', error);
});

//trail -d 
loader.load('../assets/3Dmodules/trilhodSelectable.gltf', (gltf) => {
    gltf.scene.scale.set(102, 102, 102);
    scene.add(gltf.scene);
}, undefined, (error) => {
    console.error('Error loading GLTF model:', error);
});

//Turn1 button
loader.load('../assets/3Dmodules/T1.gltf', (gltf) => {
    gltf.scene.scale.set(102, 102, 102);
  
    scene.add(gltf.scene);
}, undefined, (error) => {
    console.error('Error loading GLTF model:', error);
});


//Turn2 button
loader.load('../assets/3Dmodules/T2.gltf', (gltf) => {
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
// In your Three.js setup:
const raycaster = new THREE.Raycaster();
function onDocumentMouseDown(event) {
  event.preventDefault();

    const mouse = new THREE.Vector2();
    mouse.x =  (event.clientX / window.innerWidth)   * 2 - 1;
    mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

    raycaster.setFromCamera(mouse, camera);

    const intersects = raycaster.intersectObjects(scene.children, true);

    if (intersects.length > 0) {
        // Filter out non-selectable meshes
        const selectableIntersects = intersects.filter(intersect => {
            // Replace 'myNonSelectableMesh' with your mesh's name or a custom property
            return intersect.object.name !== 'mesh0_mesh_124'; 
            // Or, if you have a reference: return intersect.object !== nonSelectableMeshReference;
        });

        if (selectableIntersects.length > 0) {
            // Process the first selectable object
            const firstSelectableObject = selectableIntersects[0].object;
            firstSelectableObject.material.color.set(0x0000ff);
            // Your selection logic here
            console.log("Selected object:", firstSelectableObject);
        }
    }
}

document.addEventListener('mousedown', onDocumentMouseDown, false);

scene.add(light);

function animate() {
    requestAnimationFrame(animate);
    renderer.render(scene, camera);
};
animate();