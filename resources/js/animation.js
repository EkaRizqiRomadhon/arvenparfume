// scroll header class + hero parallax
const header = document.getElementById('siteHeader');
const heroBg = document.querySelector('.hero-bg-img');

window.addEventListener('scroll', () => {
  const y = window.scrollY || document.documentElement.scrollTop;
  if (header) header.classList.toggle('scrolled', y > 10);
  if (heroBg) heroBg.style.transform = `translateY(${y * 0.2}px) scale(1.05)`;
});

// tampilkan elemen .reveal saat load
window.addEventListener('load', () => {
  document.querySelectorAll('.reveal').forEach(el => el.classList.add('in'));
});

// scroll-reveal bertahap untuk card .featured-item
const items = [...document.querySelectorAll('.featured-item')];
items.forEach((el, i) => el.style.setProperty('--d', `${i * 70}ms`));
const io = new IntersectionObserver((entries) => {
  entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('in'); });
}, { threshold: 0.15 });
items.forEach(el => io.observe(el));

// efek 3D tilt halus pada .tilt-img saat hover
document.querySelectorAll('.tilt-img').forEach(img => {
  let raf = null;
  let tx = 0, ty = 0;
  function apply() {
    img.style.transform = `rotateX(${ty}deg) rotateY(${tx}deg) scale(1.015)`;
    raf = null;
  }
  img.addEventListener('mousemove', (e) => {
    const r = img.getBoundingClientRect();
    tx = ((e.clientX - r.left) / r.width  - 0.5) * 4;
    ty = -((e.clientY - r.top)  / r.height - 0.5) * 4;
    if (!raf) raf = requestAnimationFrame(apply);
  });
  img.addEventListener('mouseleave', () => { img.style.transform = ''; });
});

// efek ripple klik pada elemen .ripple
document.querySelectorAll('.ripple').forEach(btn => {
  btn.addEventListener('click', function (e) {
    const r    = document.createElement('span');
    const rect = this.getBoundingClientRect();
    r.className  = 'r';
    r.style.left = (e.clientX - rect.left) + 'px';
    r.style.top  = (e.clientY - rect.top)  + 'px';
    this.appendChild(r);
    setTimeout(() => r.remove(), 750);
  });
});

// modal emas reusable
const modal      = document.getElementById('goldModal');
const modalTitle = document.getElementById('modalTitle');
const modalImg   = document.getElementById('modalImg');
const modalLink  = document.getElementById('modalLink');

function openModal(title, src, link) {
  if (!modal) return;
  modalTitle.textContent = title || 'Preview';
  modalImg.src           = src   || '';
  modalLink.href         = link  || '#';
  modal.classList.add('show');
  document.body.style.overflow = 'hidden';
}
function closeModal() {
  if (!modal) return;
  modal.classList.remove('show');
  document.body.style.overflow = '';
}

const grid = document.getElementById('grid');
if (grid) {
  grid.addEventListener('click', (e) => {
    const trigger = e.target.closest('.open-modal');
    if (!trigger) return;
    const card = trigger.closest('.featured-item');
    if (card) openModal(card.dataset.title, card.dataset.img, card.dataset.link);
  });
}

if (modal) {
  modal.addEventListener('click', (e) => {
    if (e.target.hasAttribute('data-close')) closeModal();
  });
  window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modal.classList.contains('show')) closeModal();
  });
}

// animasi canvas gemerlap (area grid bawah)
(function () {
  const canvas = document.getElementById('sparkCanvas');
  if (!canvas) return;
  const ctx = canvas.getContext('2d', { alpha: true });
  let W, H, particles = [], last = performance.now();

  function resize() {
    W = canvas.width  = canvas.clientWidth;
    H = canvas.height = canvas.clientHeight;
  }
  window.addEventListener('resize', resize);
  resize();

  const COUNT = Math.max(60, Math.floor(W / 20));
  function reset(p, fromBottom = true) {
    p.x     = Math.random() * W;
    p.y     = fromBottom ? H + Math.random() * 40 : Math.random() * H;
    p.r     = 0.8 + Math.random() * 1.6;
    p.vx    = (Math.random() - 0.5) * 0.18;
    p.vy    = -(0.12 + Math.random() * 0.24);
    p.a     = 0.22 + Math.random() * 0.28;
    p.phase = Math.random() * Math.PI * 2;
  }
  particles = Array.from({ length: COUNT }, () => { const p = {}; reset(p, false); return p; });

  function draw(now) {
    const dt = Math.min(40, now - last);
    last = now;
    ctx.clearRect(0, 0, W, H);

    for (const p of particles) {
      p.x     += p.vx * dt;
      p.y     += p.vy * dt;
      p.phase += 0.0025 * dt;
      const pulse = (Math.sin(p.phase) + 1) / 2;
      const alpha = p.a * (0.35 + pulse * 0.65);
      if (p.y < -12 || p.x < -8 || p.x > W + 8) reset(p, true);
      const g = ctx.createRadialGradient(p.x, p.y, 0, p.x, p.y, p.r * 10);
      g.addColorStop(0, `rgba(214,193,153,${alpha})`);
      g.addColorStop(1, `rgba(163,139,93,0)`);
      ctx.fillStyle = g;
      ctx.beginPath();
      ctx.arc(p.x, p.y, p.r * 10, 0, Math.PI * 2);
      ctx.fill();
    }

    // fade mask di tepi atas
    const grad = ctx.createLinearGradient(0, 0, 0, H);
    grad.addColorStop(0,    'rgba(22,22,22,1)');
    grad.addColorStop(0.15, 'rgba(22,22,22,0)');
    ctx.fillStyle = grad;
    ctx.fillRect(0, 0, W, H * 0.18);

    requestAnimationFrame(draw);
  }
  requestAnimationFrame(draw);
})();

// mesin tik + scroll-reveal untuk judul/subjudul bagian
(function () {
  const title    = document.querySelector('#content .section-title.center');
  const subtitle = document.querySelector('#content .section-subtitle.center');
  if (!title) return;

  function typeSubtitle(el, speed = 30) {
    if (!el) return;
    const full = el.getAttribute('data-full') || el.textContent.trim();
    el.setAttribute('data-full', full);
    el.textContent = '';
    el.classList.add('typing');
    let i = 0;
    function tick() {
      if (i <= full.length) {
        el.textContent = full.slice(0, i++);
        setTimeout(tick, speed);
      } else {
        el.classList.remove('typing');
      }
    }
    tick();
  }

  const obs = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (!e.isIntersecting) return;
      title.classList.add('in');
      setTimeout(() => {
        if (subtitle) {
          subtitle.classList.add('in');
          typeSubtitle(subtitle, 28);
        }
      }, 120);
      obs.unobserve(e.target);
    });
  }, { threshold: 0.3, rootMargin: '-10% 0px -20% 0px' });

  obs.observe(title);
})();

// klik judul bagian untuk modal
(function () {
  const title = document.querySelector('#content .section-title.center');
  const modal = document.getElementById('titleModal');
  if (!title || !modal) return;

  title.style.cursor = 'pointer';
  title.addEventListener('click', () => {
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
  });

  modal.addEventListener('click', e => {
    if (e.target.hasAttribute('data-close')) {
      modal.classList.remove('show');
      document.body.style.overflow = '';
    }
  });

  window.addEventListener('keydown', e => {
    if (e.key === 'Escape' && modal.classList.contains('show')) {
      modal.classList.remove('show');
      document.body.style.overflow = '';
    }
  });
})();

// scroll-reveal sekali untuk .section-title.center
document.addEventListener('DOMContentLoaded', () => {
  const title = document.querySelector('.section-title.center');
  if (!title) return;
  const obs = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        title.classList.add('show');
        obs.unobserve(entry.target);
      }
    });
  }, { threshold: 0.3 });
  obs.observe(title);
});