import * as THREE from '../node_modules/three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
function main(){
 const scene = new THREE.Scene();
 let camera =  new THREE.PerspectiveCamera(75,window.innerHeight/window.innerWidth,100)
const canvas = document.querySelector('#map');
const renderer = new THREE.WebGLRenderer({antialias: true, canvas});
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.body.appendChild(renderer.domElement);

    const geometry = new THREE.BoxGeometry(1, 3, 5);
    const material = new THREE.MeshBasicMaterial({ color: 0x0020ff});
    const cube = new THREE.Mesh(geometry, material);
    scene.add(cube);

    camera.position.z= 2
    function animate() {
        requestAnimationFrame(animate);
        cube.rotation.x += 0.01;
        renderer.render(scene, camera);
    }
                   
    animate();
}
main();