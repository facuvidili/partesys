const el = document.getElementById('icono');
const height = el.clientHeight;
const width = el.clientWidth;

el.addEventListener('mousemove', (evt) => {
    const {layerX, layerY} = evt;
    const yRotation = ((layerX - width / 2) / width) * 20;
    const xRotation = ((layerY - height / 2) / height) * 20;
    el.style.transform = `perspective(500px) scale(1.1) rotateX(${xRotation}deg) rotateY(${yRotation}deg)`;
});
el.addEventListener('mouseout', () => {
    el.style.transform = `perspective(500px) scale(1) rotateX(0) rotateY(0)`;
});