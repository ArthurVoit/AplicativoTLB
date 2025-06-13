import * as THREE from 'https://cdn.jsdelivr.net/npm/three@0.177.0/build/three.module.js';
import { GLTFLoader } from 'https://cdn.jsdelivr.net/npm/three@0.177.0/examples/jsm/loaders/GLTFLoader.js';
import { OrbitControls } from 'https://cdn.jsdelivr.net/npm/three@0.177.0/examples/jsm/controls/OrbitControls.js';

console.log('Script rodando');

const cena = new THREE.Scene();
cena.background = new THREE.Color(0xffffff); // Fundo azul claro

const camera = new THREE.PerspectiveCamera(
  75,
  window.innerWidth / window.innerHeight,
  0.1,
  1000
);
camera.position.set(0, 5, 15); // Ajuste inicial para boa visão do trem

const renderizador = new THREE.WebGLRenderer({ antialias: true });
renderizador.setSize(window.innerWidth, window.innerHeight);
document.getElementById('trem3D').appendChild(renderizador.domElement);

// Criando iluminação mais realista
const luzAmbiente = new THREE.AmbientLight(0xffffff, 0.6); // Luz difusa e uniforme
cena.add(luzAmbiente);

const luzDirecional1 = new THREE.DirectionalLight(0xffffff, 0.8);
luzDirecional1.position.set(5, 5, 5);
cena.add(luzDirecional1);

const luzDirecional2 = new THREE.DirectionalLight(0xffffff, 0.6);
luzDirecional2.position.set(-5, 5, 5);
cena.add(luzDirecional2);

const luzPontual = new THREE.PointLight(0xffffff, 1, 50);
luzPontual.position.set(0, 5, 5);
cena.add(luzPontual);

const loader = new GLTFLoader();
console.log('Tentando carregar modelo: ../assets/trainv1.gltf');

let trem;
loader.load('../assets/3Dmodules/trainv1.gltf',
  function (gltf) {
    trem = gltf.scene;
    trem.scale.set(102, 102, 102);
    trem.rotation.set(Math.PI / 2.3, Math.PI, 33);
    cena.add(trem);
  },
  undefined,
  function (erro) {
    console.error('Erro ao carregar o modelo:', erro);
  }
);

const controles = new OrbitControls(camera, renderizador.domElement);
controles.enableDamping = true;
controles.dampingFactor = 0.05;
controles.screenSpacePanning = false;
controles.maxPolarAngle = Math.PI / 2;
controles.enableZoom = true;
controles.enableRotate = true;
controles.enablePan = true;

function animar() {
  requestAnimationFrame(animar);
  controles.update();
  renderizador.render(cena, camera);
}

animar();
