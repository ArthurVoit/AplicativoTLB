import * as THREE from '../node_modules/three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
function main(){
const scene = new THREE.Scene();

let camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 100);
camera.position.set(0, 1, 5);

const canvas = document.querySelector('#map');
const renderer = new THREE.WebGLRenderer({ antialias: true, canvas });
renderer.setSize(window.innerWidth, window.innerHeight);
document.body.appendChild(renderer.domElement);

const loader = new GLTFLoader();
loader.load('path/to/your/model.gltf', (gltf) => {
    scene.add(gltf.scene);
}, undefined, (error) => {
    console.error('Error loading GLTF model:', error);
});

const light = new THREE.AmbientLight(0xffffff, 1);
scene.add(light);

function animate() {
    requestAnimationFrame(animate);
    renderer.render(scene, camera);
}

animate();
}
main();