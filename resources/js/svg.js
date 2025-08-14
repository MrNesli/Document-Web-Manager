/* SVG Tutorial: https://www.fullstackfoundations.com/blog/web-developer-svg */

const menu = document.querySelector('.menu');

function addDivLabel(options) {
  const width = options.width;
  const height = options.height;
  const div = document.createElement('div');
  div.setAttribute('class', `font-comfortaa absolute bottom-[25px] left-[130px] text-white px-4 py-2 rounded-md bg-linear-to-r from-[#FD814A] to-[#FC5C4C]`);
  div.textContent = 'À propos';

  menu.appendChild(div);
}

function addSvgBtn(options) {
  const width = options.width ? options.width : 360;
  const height = options.height ? options.height : 90;
  let ar = options.arc_radius ? options.arc_radius : 0;

  const btnSvg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
  btnSvg.setAttribute('class', `absolute hover:cursor-pointer`);
  btnSvg.setAttribute('viewBox', `0 0 ${ar * 2} ${ar * 2}`);
  btnSvg.setAttribute('width', `${ar * 2}`);
  btnSvg.setAttribute('height', `${ar * 2}`);
  btnSvg.setAttribute('fill', 'orange');
  btnSvg.innerHTML = `
    <g filter="url(#filter0_d_3_190)">
      <rect x="4" width="64" height="64" rx="32" fill="url(#paint0_linear_3_190)"/>
    </g>
    <path d="M25.3333 32H46.6667" stroke="white" stroke-width="3" stroke-linecap="round"/>
    <path d="M36 21.3334L36 42.6667" stroke="white" stroke-width="3" stroke-linecap="round"/>
    <defs>
      <filter id="filter0_d_3_190" x="0" y="0" width="72" height="72" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
        <feOffset dy="4"/>
        <feGaussianBlur stdDeviation="2"/>
        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_3_190"/>
        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_3_190" result="shape"/>
      </filter>

      <linearGradient id="paint0_linear_3_190" x1="12.8889" y1="-3.55557" x2="55.5556" y2="64" gradientUnits="userSpaceOnUse">
        <stop stop-color="#FFAC5F"/>
        <stop offset="1" stop-color="#FF4D3C"/>
      </linearGradient>
    </defs>
  `

  const leftPos = (width / 2) - ar + 4;
  const bottomPos = height - ar - 8;

  btnSvg.style.bottom = `${bottomPos - 10}px`;
  btnSvg.style.left = `${leftPos}px`;

  menu.appendChild(btnSvg);
}

function addSvgMenu(options) {
  // options.rounded_top_left
  // options.rounded_top_right
  // options.rounded_bottom_left
  // options.rounded_bottom_right

  if (!options) options = {};

  const width = options.width ? options.width : 360;
  const height = options.height ? options.height : 90;

  const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
  svg.setAttribute('class', 'drop-shadow-menu');
  svg.setAttribute('viewBox', `0 0 ${width} ${height}`);
  svg.setAttribute('width', width);
  svg.setAttribute('height', height);
  svg.setAttribute('preserveAspectRatio', 'xMidYMid meet');
  svg.setAttribute('fill', 'white');

  const path = document.createElementNS("http://www.w3.org/2000/svg", "path");

  // Drawing the rectangular shape with rounded corners
  let rounded_top_left = options.rounded_top_left ? options.rounded_top_left : 0;
  let tl_radius = rounded_top_left;
  let top_left_corner = `L0 ${rounded_top_left} A${tl_radius} ${tl_radius} 0 0 1 ${rounded_top_left} 0`

  let rounded_top_right = options.rounded_top_right ? options.rounded_top_right : 0;
  let tr_radius = rounded_top_right;
  let top_right_corner = `L${width - rounded_top_right} 0 A${tr_radius} ${tr_radius} 0 0 1 ${width} ${rounded_top_right}`

  let rounded_bottom_right = options.rounded_bottom_right ? options.rounded_bottom_right : 0;
  let br_radius = rounded_bottom_right;
  let bottom_right_corner = `L${width} ${height - rounded_bottom_right} A${br_radius} ${br_radius} 0 0 1 ${width - rounded_bottom_right} ${height}`

  let rounded_bottom_left = options.rounded_bottom_left ? options.rounded_bottom_left : 0;
  let bl_radius = rounded_bottom_left;
  let bottom_left_corner = `L${rounded_bottom_left} ${height} A${bl_radius} ${bl_radius} 0 0 1 0 ${height - rounded_bottom_left}`

  // Drawing an arc with rounded corners in the middle of the menu
  let arc = '';

  if (options.arc_radius) {
    let left = (width / 2) - options.arc_radius;
    let right = (width / 2) + options.arc_radius;

    let ar = options.arc_radius ? options.arc_radius : 0;
    let arl = options.arc_rounded_left ? options.arc_rounded_left : 0;
    let arr = options.arc_rounded_right ? options.arc_rounded_right : 0;

    let l_radius = arl;
    let r_radius = arr;

    let left_corner = `L${left - arl} 0 A${l_radius} ${l_radius} 0 0 1 ${left} ${arl}`;
    let arc_el = `A${ar} ${ar} 0 0 0 ${right} ${arr}`;
    let right_corner = `A${r_radius} ${r_radius} 0 0 1 ${right + arr} 0`;
    arc = `${left_corner} ${arc_el} ${right_corner}`;
  }


  // Final element's path
  path.setAttribute('d', `M0 ${height} ${top_left_corner} ${arc} ${top_right_corner} ${bottom_right_corner} ${bottom_left_corner}`);

  svg.appendChild(path);
  menu.appendChild(svg);
}

const options = {
  width: 360,
  height: 90,
  rounded_top_left: 50,
  rounded_top_right: 50,
  // rounded_bottom_right: 50,
  // rounded_bottom_left: 50,
  arc_rounded_left: 15,
  arc_rounded_right: 15,
  arc_radius: 40,
};

addSvgMenu(options);
// addDivLabel(options);
addSvgBtn(options);
