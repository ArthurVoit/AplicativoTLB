import * as THREE from 'https://cdn.jsdelivr.net/npm/three@0.177.0/build/three.module.js';
import { GLTFLoader } from 'https://cdn.jsdelivr.net/npm/three@0.177.0/examples/jsm/loaders/GLTFLoader.js';
console.log('Script rodando');



const cena = new THREE.Scene();


const camera = new THREE.PerspectiveCamera(
  75,
  window.innerWidth / window.innerHeight,
  0.1,
  1000
);

const renderizador = new THREE.WebGLRenderer({ antialias: true });
renderizador.setSize(window.innerWidth, window.innerHeight);
document.getElementById('trem3D').appendChild(renderizador.domElement);


const luz = new THREE.DirectionalLight(0xffffff, 1);
luz.position.set(1, 1, 1).normalize();
cena.add(luz);


const loader = new GLTFLoader();
console.log('Tentando carregar modelo: ../assets/trainv1.gltf');
loader.load('../assets/3Dmodules/trainv1.gltf',
  function (gltf) {
    cena.add(gltf.scene);
  },
  undefined,
  function (erro) {
    console.error('Erro ao carregar o modelo:', erro);
  }
);


camera.position.z = 5;


function animar() {
  requestAnimationFrame(animar);
  renderizador.render(cena, camera);
}
animar();
