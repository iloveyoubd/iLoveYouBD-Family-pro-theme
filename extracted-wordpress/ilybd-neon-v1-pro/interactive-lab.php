<?php
/* Template Name: CyberX Interactive AI Lab v2 */
get_header();
?>

<div id="cyber-lab-root">

    <!-- UI LAYER -->
    <div id="ui-layer">
        <h2>CYBER LAB v2.0</h2>
        <p id="status">SYSTEM INITIALIZING...</p>

        <button id="spawn-btn">Spawn Agent</button>
        <button id="chat-btn">Talk to World</button>
    </div>

    <!-- CANVAS -->
    <div id="canvas-container"></div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

<script>
/* =====================================
   1. BASIC ENGINE SETUP
===================================== */
const scene = new THREE.Scene();
scene.background = new THREE.Color(0x050505);

const camera = new THREE.PerspectiveCamera(
    60,
    window.innerWidth / window.innerHeight,
    0.1,
    1000
);

camera.position.set(0, 4, 10);

const renderer = new THREE.WebGLRenderer({ antialias: true });
renderer.setSize(window.innerWidth, window.innerHeight);
document.getElementById("canvas-container").appendChild(renderer.domElement);


/* =====================================
   2. LIGHT SYSTEM
===================================== */
const light = new THREE.PointLight(0x00ffcc, 2, 100);
light.position.set(5, 10, 5);
scene.add(light);

scene.add(new THREE.AmbientLight(0xffffff, 0.25));


/* =====================================
   3. WORLD (GROUND + GRID)
===================================== */
const ground = new THREE.Mesh(
    new THREE.PlaneGeometry(50, 50),
    new THREE.MeshStandardMaterial({ color: 0x0a0a0a })
);

ground.rotation.x = -Math.PI / 2;
scene.add(ground);


/* =====================================
   4. AGENT SYSTEM (HUMAN NPCs)
===================================== */
const agents = [];

function createAgent(x = 0, z = 0) {

    const group = new THREE.Group();

    const body = new THREE.Mesh(
        new THREE.CapsuleGeometry(0.3, 1, 4, 8),
        new THREE.MeshStandardMaterial({ color: 0x1f1f1f })
    );

    const head = new THREE.Mesh(
        new THREE.SphereGeometry(0.25, 12, 12),
        new THREE.MeshStandardMaterial({ color: 0xffcc99 })
    );

    head.position.y = 1.5;

    group.add(body);
    group.add(head);

    group.position.set(x, 0, z);

    scene.add(group);

    agents.push({
        mesh: group,
        speed: 0.02 + Math.random() * 0.02,
        dir: Math.random() * Math.PI * 2
    });
}


/* =====================================
   5. RANDOM MOVEMENT AI
===================================== */
function updateAgents() {

    agents.forEach(a => {

        a.mesh.position.x += Math.cos(a.dir) * a.speed;
        a.mesh.position.z += Math.sin(a.dir) * a.speed;

        if (Math.random() < 0.01) {
            a.dir += (Math.random() - 0.5);
        }
    });
}


/* =====================================
   6. SPEECH SYSTEM (LOCAL AI VOICE)
===================================== */
function speak(text) {

    const msg = new SpeechSynthesisUtterance(text);
    msg.rate = 0.9;
    msg.pitch = 1.1;

    document.getElementById("status").innerText = "AI TALKING...";

    msg.onend = () => {
        document.getElementById("status").innerText = "IDLE";
    };

    speechSynthesis.speak(msg);
}


/* =====================================
   7. UI EVENTS
===================================== */
document.getElementById("spawn-btn").onclick = () => {
    createAgent(
        (Math.random() - 0.5) * 10,
        (Math.random() - 0.5) * 10
    );
};

document.getElementById("chat-btn").onclick = () => {
    speak("Cyber world is now active. Agents are running in simulation mode.");
};


/* =====================================
   8. ANIMATION LOOP
===================================== */
function animate() {
    requestAnimationFrame(animate);

    updateAgents();

    renderer.render(scene, camera);
}

animate();


/* =====================================
   9. RESIZE FIX
===================================== */
window.addEventListener("resize", () => {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
});
</script>


<style>
#cyber-lab-root{
    width:100%;
    height:100vh;
    position:relative;
    overflow:hidden;
    background:#000;
}

#ui-layer{
    position:absolute;
    top:20px;
    left:20px;
    z-index:10;
    color:#00ffcc;
    font-family:monospace;
}

#ui-layer button{
    display:block;
    margin-top:10px;
    padding:10px 15px;
    background:#00ffcc;
    border:none;
    cursor:pointer;
    font-weight:bold;
}

#canvas-container{
    width:100%;
    height:100%;
}
</style>

<?php get_footer(); ?>