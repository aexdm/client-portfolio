const perf = {
  reduced: window.matchMedia?.("(prefers-reduced-motion: reduce)")?.matches || false,
  lowPower: (navigator.hardwareConcurrency || 4) <= 4 || (navigator.deviceMemory || 4) <= 4,
};
document.documentElement.classList.toggle("perf-lite", perf.reduced || perf.lowPower);

function refreshIcons(root = document) {
  if (window.lucide?.createIcons) lucide.createIcons({ attrs: { "stroke-width": 1.75 }, root });
}

function switchTab(id) {
  const panel = document.getElementById(id);
  if (!panel) return;
  document.querySelectorAll(".tab").forEach(t => t.classList.remove("active"));
  document.querySelectorAll(".nav-link").forEach(b => b.classList.remove("active"));
  document.querySelectorAll(".mobile-nav-btn").forEach(b => b.classList.remove("active"));
  panel.classList.add("active");
  const btn  = document.getElementById("nav-" + id);
  const mBtn = document.getElementById("mnav-" + id);
  if (btn)  btn.classList.add("active");
  if (mBtn) mBtn.classList.add("active");
  const main = document.querySelector(".main");
  if (main) main.scrollTop = 0;
  const homeCanvas = document.getElementById("homeStarCanvas");
  if (homeCanvas) homeCanvas.classList.toggle("visible", id === "home");
  refreshIcons(panel);
}

const cycleWords = window.EVREN_CYCLE_WORDS || [
  "le cinéma", "tourner", "écrire", "raconter", "la lumière",
  "le cadrage", "les sons", "l'image", "créer",
  "les couleurs", "le noir et blanc", "les ambiances", "la mise en scène",
];

const placeholderRoadmap = [
  {
    cat: "placeholder",
    title: "place holder text",
    desc: "place holder text",
    items: ["place holder text"],
    status: "wip",
  },
];

let wordIndex = 0;
setInterval(() => {
  if (document.hidden || perf.reduced) return;
  const el = document.getElementById("aboutWord");
  if (!el) return;
  el.style.opacity   = "0";
  el.style.transform = "translateY(-5px)";
  setTimeout(() => {
    el.textContent     = cycleWords[wordIndex];
    el.style.opacity   = "1";
    el.style.transform = "translateY(0)";
    wordIndex = (wordIndex + 1) % cycleWords.length;
  }, 220);
}, perf.lowPower ? 3200 : 1800);

function setupCopyEmailButtons() {
  const buttons = document.querySelectorAll("[data-copy-email]");
  if (!buttons.length) return;

  let tooltip = document.querySelector(".copy-tooltip");
  if (!tooltip) {
    tooltip = document.createElement("div");
    tooltip.className = "copy-tooltip";
    tooltip.textContent = "Copier ?";
    document.body.appendChild(tooltip);
  }

  let resetTimer;

  const moveTooltip = (event) => {
    tooltip.style.left = `${event.clientX}px`;
    tooltip.style.top = `${event.clientY}px`;
  };

  buttons.forEach((button) => {
    if (button.dataset.copyReady === "true") return;
    button.dataset.copyReady = "true";

    button.addEventListener("mouseenter", () => {
      tooltip.textContent = "Copier ?";
      tooltip.classList.add("visible");
    });

    button.addEventListener("mousemove", moveTooltip);

    button.addEventListener("mouseleave", () => {
      tooltip.classList.remove("visible");
      tooltip.textContent = "Copier ?";
      clearTimeout(resetTimer);
    });

    button.addEventListener("click", async () => {
      const email = button.dataset.copyEmail;
      if (!email) return;

      try {
        await navigator.clipboard.writeText(email);
      } catch (error) {
        const helper = document.createElement("textarea");
        helper.value = email;
        helper.setAttribute("readonly", "");
        helper.style.position = "absolute";
        helper.style.left = "-9999px";
        document.body.appendChild(helper);
        helper.select();
        document.execCommand("copy");
        helper.remove();
      }

      tooltip.textContent = "Copier!";
      tooltip.classList.add("visible");
      clearTimeout(resetTimer);
      resetTimer = setTimeout(() => {
        tooltip.textContent = "Copier ?";
      }, 1100);
    });
  });
}

const projectData = window.EVREN_PROJECT_DATA || {
  "UMAMI": {
    lang: "// drame musical · 20 min",
    intro: "Mon tout premier court-métrage, et mon premier vrai pas dans la réalisation.",
    description: "Marqué par la trahison de son ancien ami, Aaron, un jeune beatmaker se donne pour mission de révolutionner la musique en inventant un nouveau style : l'Umami. Pour faire exister sa vision, il est prêt à tout, quitte à se heurter aux critiques des plus grands de son milieu.\n\nC'est un Projet très personnel, porté par un message profond et essentiel à mes yeux.",
    tags: ["TRAVAUX EN COURS", "COURT MÉTRAGE", "20 MIN", "MUSIQUE"],
    images: [
      "Images/Projet/tournage/UMAMI/tournage1 umami (1).jpg",
      "Images/Projet/tournage/UMAMI/tournage1 umami (2).jpg",
      "Images/Projet/tournage/UMAMI/tournage1 umami (3).jpg",
      "Images/Projet/tournage/UMAMI/tournage1 umami (4).jpg",
      "Images/Projet/tournage/UMAMI/tournage1 umami (5).jpg",
      "Images/Projet/tournage/UMAMI/tournage1 umami (6).jpg",
      "Images/Projet/tournage/UMAMI/tournage1 umami (7).jpg",
    ],
    details: {
      sortie: "2 et 3 mai 2026",
      tournage: "environ 6 à 7 jours",
      duree: "en cours depuis près de 11 mois",
      acteurs: "7 à 10 acteurs/trices",
      role: "réalisateur",
      lieu: "[festival local], 2026",      status: "wip",
    },
    roadmap: placeholderRoadmap,
  },
  "Versatile Musique Saison 1": {
    lang: "// série musicale · saison 1",
    intro: "Une première immersion concrète dans l'audiovisuel à travers un grand Projet musical.",
    description: "Dans cette première saison de Versatile Musique, 11 artistes français de la région parisienne se réunissent pour faire vibrer les cœurs et lever les bras du public. Chacun y affirme son style, sa culture et son énergie pour faire découvrir un nouvel univers musical.\n\nCe Projet important pour mon association m'a permis de faire mes premiers pas dans l'audiovisuel et de rencontrer des personnes incroyables.",
    tags: ["TERMINÉ", "SÉRIE MUSICALE", "Projet COLLABORATIF", "MUSIQUE"],
    images: [
      "Images/Projet/tournage/VERSATILE/tournage versatile.jpg",
      "Images/Projet/tournage/VERSATILE/tournage versatile 1.jpg",
      "Images/Projet/tournage/VERSATILE/tournage versatile 2.jpg",
      "Images/Projet/tournage/VERSATILE/tournage versatile 3.jpg",
      "Images/Projet/tournage/VERSATILE/tournage versatile 4.jpg",
      "Images/Projet/tournage/VERSATILE/tournage versatile 5.jpg",
      "Images/Projet/tournage/VERSATILE/versatile 6.jpg",
      "Images/Projet/tournage/VERSATILE/versatile 7.jpg",
      "Images/Projet/tournage/VERSATILE/versatile 8.jpg",
      "Images/Projet/tournage/VERSATILE/versatile 9.jpg",
      "Images/Projet/tournage/VERSATILE/versatile 10.jpg",
    ],
    details: {
      sortie: "Showcase : 23 et 24 avril 2026 — Version finale : 2 et 3 mai 2026",
      tournage: "environ 2 à 3 semaines",
      duree: "en cours depuis 2 à 3 années",
      acteurs: "11 artistes principaux + 3 à 4 artistes secondaires",
      role: "photographe d'événements, assistant cam",
      lieu: "[festival local], 2 et 3 mai 2026",
      status: "done",
    },
    roadmap: placeholderRoadmap,
  },
  "لا تنسى": {
    lang: "// drame · mémoire & origines · 15 min",
    intro: "Un récit sensible sur la mémoire, les origines et ce qu'on choisit de transmettre.",
    description: "Parce qu'il est essentiel de savoir d'où l'on vient pour comprendre où l'on va, une jeune femme décide d'aider de tout son cœur son voisin, déterminé à rejeter ses origines, son histoire et son passé.\n\nCette histoire profonde et touchante m'a offert un tournage riche en apprentissages et a nourri ma vision du cinéma et de la réalisation.",
    tags: ["TRAVAUX EN COURS", "ORIGINES", "TRISTE", "15 MIN"],
    images: [
      "Images/Projet/tournage/NP/tournage n'oublie pas.jpg",
      "Images/Projet/tournage/NP/tournage n'oublie pas 1.jpg",
      "Images/Projet/tournage/NP/tournage n'oublie pas 2.jpg",
      "Images/Projet/tournage/NP/tournage n'oublie pas 3.png",
      "Images/Projet/tournage/NP/tournage n'oublie pas 4.png",
    ],
    details: {
      sortie: "date de sortie non encore déterminée",
      tournage: "environ 2 jours",
      duree: "en cours depuis près de 5 mois",
      acteurs: "5 à 8 acteurs/trices",
      role: "script, assistant électro",
      lieu: "lieu et date de sortie non encore déterminés",
      status: "wip",
    },
    roadmap: placeholderRoadmap,
  },
  "LOIN DES FRONTIÈRES": {
    lang: "// drame social · 10 min",
    intro: "Un court-métrage porté par un message de paix et d'espoir pour la jeunesse.",
    description: "Samba, un jeune homme ayant fui son pays à cause de la guerre, rejoint un collège en France. Ne maîtrisant pas encore bien la langue, il devient la cible des autres élèves. À travers lui, ce court-métrage défend un message de paix, de solidarité et d'espoir pour les jeunes du monde entier.\n\nJ'ai eu la chance d'y participer comme assistant réalisateur, une expérience qui m'a permis d'affiner ma compréhension du rôle de réalisateur à travers le regard d'un autre cinéaste.",
    tags: ["TRAVAUX EN COURS", "COURT MÉTRAGE", "ÉDUCATION"],
    images: [
      "Images/Projet/tournage/LDF/tournage loin des frontières.jpg",
      "Images/Projet/tournage/LDF/tournage loin des frontières 1.jpg",
      "Images/Projet/tournage/LDF/tournage loin des frontières 2.jpg",
      "Images/Projet/tournage/LDF/tournage loin des frontières 3.jpg",
      "Images/Projet/tournage/LDF/tournage loin des frontières 4.jpg",
      "Images/Projet/tournage/LDF/tournage loin des frontières 5.jpg",
    ],
    details: {
      sortie: "au mois de juin (date exacte non encore déterminée)",
      tournage: "environ 3 jours",
      duree: "en cours depuis près de 4 mois",
      acteurs: "15 à 20 acteurs/trices",
      role: "Technicien responsable du clap, assistant électro, assistant cam, assistant réalisateur, directeur de la figuration",
      lieu: "lieu et date exacte non encore déterminés",
      status: "wip",
    },
    roadmap: placeholderRoadmap,
  },
};

function openProjectModal(projectName) {
  const data        = projectData[projectName] || {};
  const placeholder = "https://placehold.co/930x480/111111/333333?text=" + encodeURIComponent(projectName);
  const mediaUrl = (entry) => typeof entry === "string" ? entry : entry?.src || entry?.url || "";
  const mergedMedia = [...(data.images || []), ...(data.videos || [])]
    .filter(Boolean)
    .filter((item, index, arr) => arr.findIndex(other => mediaUrl(other) === mediaUrl(item)) === index);
  const images      = mergedMedia.length ? mergedMedia : [placeholder];

  document.getElementById("pModalLang").textContent        = data.lang        || "// film";
  document.getElementById("pModalTitle").textContent       = projectName;
  document.getElementById("pModalIntro").textContent       = data.intro        || "";
  const rawDesc = data.description || "";
  document.getElementById("pModalDescription").innerHTML = rawDesc.replace(/\n\n/g, "<br><br>").replace(/\n/g, "<br>");

  const mediaHost = document.querySelector(".pmodal-gallery-main");
  const thumbsWrap = document.getElementById("pModalThumbs");
  thumbsWrap.innerHTML = "";

  const isVideoMedia = (src) => /\.(mp4|webm|ogg|ogv|mov)(\?.*)?$/i.test(src || "") || /\/video\/upload\//i.test(src || "");
  const cloudinaryVideoUrl = (src) => {
    if (!/^https:\/\/res\.cloudinary\.com\/[^/]+\/video\/upload\//i.test(src || "")) return src;
    return src.includes("/video/upload/q_auto:eco,vc_auto/")
      ? src
      : src.replace(/\/video\/upload\//i, "/video/upload/q_auto:eco,vc_auto/");
  };
  const videoPosterUrl = (src) => {
    if (!/^https:\/\/res\.cloudinary\.com\/[^/]+\/video\/upload\//i.test(src || "")) return "";
    return src
      .replace(/\/video\/upload\/(?:[^/]+\/)?/i, "/video/upload/so_0,w_640,h_360,c_fill,q_auto,f_jpg/")
      .replace(/\.(mp4|webm|ogg|ogv|mov)(\?.*)?$/i, ".jpg$2");
  };

  function renderMainMedia(index, instant = false) {
    const src = mediaUrl(images[index]);
    if (!mediaHost || !src) return;
    const oldMedia = mediaHost.querySelector("#pModalImgMain, .pmodal-video-file");
    if (oldMedia) oldMedia.style.opacity = instant ? "1" : "0";
    setTimeout(() => {
      mediaHost.querySelector("#pModalImgMain, .pmodal-video-file")?.remove();
      const node = isVideoMedia(src) ? document.createElement("video") : document.createElement("img");
      if (isVideoMedia(src)) {
        node.className = "pmodal-video-file";
        node.controls = true;
        node.playsInline = true;
        node.preload = "none";
        node.poster = videoPosterUrl(src);
      } else {
        node.id = "pModalImgMain";
        node.alt = `${projectName} ${index + 1}`;
        node.loading = "eager";
        node.decoding = "async";
      }
      node.src = isVideoMedia(src) ? cloudinaryVideoUrl(src) : src;
      node.style.opacity = instant ? "1" : "0";
      mediaHost.prepend(node);
      requestAnimationFrame(() => { node.style.opacity = "1"; });
    }, instant ? 0 : 150);
  }

  renderMainMedia(0, true);

  function setActiveImage(index) {
    renderMainMedia(index);
    thumbsWrap.querySelectorAll(".pmodal-thumb").forEach((thumb, thumbIndex) => {
      thumb.classList.toggle("active", thumbIndex === index);
    });
  }

  images.forEach((entry, index) => {
    const src = mediaUrl(entry);
    const thumb = document.createElement(isVideoMedia(src) ? "button" : "img");
    thumb.className = "pmodal-thumb" + (isVideoMedia(src) ? " pmodal-thumb-video" : "") + (index === 0 ? " active" : "");
    if (isVideoMedia(src)) {
      thumb.type = "button";
      const poster = videoPosterUrl(src);
      if (poster) thumb.style.backgroundImage = `url('${poster.replace(/'/g, "\\'")}')`;
      thumb.innerHTML = "<span>play</span>";
    } else {
      thumb.src = src;
      thumb.alt = `${projectName} ${index + 1}`;
      thumb.loading = "lazy";
      thumb.decoding = "async";
    }
    thumb.dataset.idx = String(index);
    thumb.onclick = () => setActiveImage(index);
    thumbsWrap.appendChild(thumb);
  });
  thumbsWrap.classList.toggle("scrollable", images.length > 4);
  mediaHost?.closest(".pmodal-gallery-col")?.classList.toggle("has-scroll", images.length > 4);
  thumbsWrap.onwheel = (event) => {
    if (thumbsWrap.scrollWidth <= thumbsWrap.clientWidth) return;
    const delta = Math.abs(event.deltaY) > Math.abs(event.deltaX) ? event.deltaY : event.deltaX;
    thumbsWrap.scrollLeft += delta;
    event.preventDefault();
  };

  const actionBtn = document.getElementById("pModalAction");
  actionBtn.hidden = true;
  actionBtn.href = data.action?.href || "#";
  document.getElementById("pModalActionLabel").textContent = data.action?.label || "Voir le Projet";

  const tabBtns        = document.getElementById("pModalTabBtns");
  const roadmapContent = document.getElementById("pModalRoadmapContent");
  tabBtns.innerHTML = roadmapContent.innerHTML = "";
  const details = data.details;
  if (details) {
    const statusClass = details.status === "done" ? "pmodal-status-done" : "pmodal-status-wip";
    const statusText  = details.status === "done" ? "terminé" : "en cours";
    const detailsCard = document.createElement("div");
    detailsCard.className = "pmodal-roadmap-panel active";
    detailsCard.innerHTML = `
      <div class="pmodal-details-card">
        <div class="pmodal-detail-row">
          <span class="pmodal-detail-icon">📅</span>
          <div><div class="pmodal-detail-label">date de sortie</div><div class="pmodal-detail-val">${details.sortie}</div></div>
        </div>
        <div class="pmodal-detail-row">
          <span class="pmodal-detail-icon">🎬</span>
          <div><div class="pmodal-detail-label">jours de tournage</div><div class="pmodal-detail-val">${details.tournage}</div></div>
        </div>
        <div class="pmodal-detail-row">
          <span class="pmodal-detail-icon">⏱️</span>
          <div><div class="pmodal-detail-label">depuis combien de temps</div><div class="pmodal-detail-val">${details.duree}</div></div>
        </div>
        <div class="pmodal-detail-row">
          <span class="pmodal-detail-icon">👥</span>
          <div><div class="pmodal-detail-label">nombre d'acteurs/artistes</div><div class="pmodal-detail-val">${details.acteurs}</div></div>
        </div>
        <div class="pmodal-detail-row">
          <span class="pmodal-detail-icon">🎭</span>
          <div><div class="pmodal-detail-label">mon rôle</div><div class="pmodal-detail-val">${details.role}</div></div>
        </div>
        <div class="pmodal-detail-row">
          <span class="pmodal-detail-icon">📍</span>
          <div><div class="pmodal-detail-label">lieu de sortie finale</div><div class="pmodal-detail-val">${details.lieu}</div></div>
        </div>
        <div style="margin-top:10px;"><span class="${statusClass}">${statusText}</span></div>
      </div>`;
    roadmapContent.appendChild(detailsCard);
  } else {
    roadmapContent.innerHTML = `<p style="font-family:var(--mono);font-size:11.5px;color:var(--muted);">// aucun détail disponible</p>`;
  }

  tabBtns.style.display = "none";

  document.getElementById("projectModal").classList.add("open");
  refreshIcons();
}

function closeProjectModal() {
  document.querySelectorAll("#projectModal video").forEach(video => {
    video.pause();
    video.removeAttribute("src");
    video.load();
  });
  document.getElementById("projectModal").classList.remove("open");
}
document.getElementById("projectModal").addEventListener("click", e => {
  if (e.target.id === "projectModal") closeProjectModal();
});
document.querySelectorAll(".project-card").forEach(card => {
  card.addEventListener("click", e => {
    if (e.target.closest(".project-card-ext")) return;
    e.preventDefault();
    const name = card.dataset.project || card.querySelector(".project-card-name")?.textContent?.trim() || "";
    openProjectModal(name);
  });
});

const themes = {
  midnight: {
    "--bg": "#080808", "--bg2": "#0f0f0f", "--card": "#141414", "--card-hover": "#1c1c1c",
    "--border": "rgba(255,255,255,0.07)", "--border2": "rgba(255,255,255,0.15)",
    "--text": "#f0f0f0", "--muted": "rgba(255,255,255,0.38)",
    "--amber": "#ffffff", "--amber-dim": "rgba(255,255,255,0.08)", "--amber-dim2": "rgba(255,255,255,0.16)",
    "--green": "#c8c8c8", "--green-dim": "rgba(200,200,200,0.10)",
  },
  noir: {
    "--bg": "#050505", "--bg2": "#0a0a0a", "--card": "#101010", "--card-hover": "#181818",
    "--border": "rgba(255,255,255,0.05)", "--border2": "rgba(255,255,255,0.10)",
    "--text": "#e8e8e8", "--muted": "rgba(255,255,255,0.30)",
    "--amber": "#d0d0d0", "--amber-dim": "rgba(208,208,208,0.08)", "--amber-dim2": "rgba(208,208,208,0.14)",
    "--green": "#aaaaaa", "--green-dim": "rgba(170,170,170,0.10)",
  },
  rouge: {
    "--bg": "#0a0808", "--bg2": "#110c0c", "--card": "#1a1010", "--card-hover": "#221414",
    "--border": "rgba(255,80,80,0.1)", "--border2": "rgba(255,80,80,0.2)",
    "--text": "#f5e8e8", "--muted": "rgba(255,200,200,0.4)",
    "--amber": "#fa4a4a", "--amber-dim": "rgba(255,77,77,0.1)", "--amber-dim2": "rgba(255,77,77,0.2)",
    "--green": "#ff9e9e", "--green-dim": "rgba(255,158,158,0.10)",
  },
  bleu: {
    "--bg": "#08090a", "--bg2": "#0c0f12", "--card": "#101418", "--card-hover": "#161c24",
    "--border": "rgba(80,130,255,0.1)", "--border2": "rgba(80,130,255,0.2)",
    "--text": "#e8eeff", "--muted": "rgba(180,200,255,0.4)",
    "--amber": "#4da6ff", "--amber-dim": "rgba(77,166,255,0.1)", "--amber-dim2": "rgba(77,166,255,0.2)",
    "--green": "#9effa6", "--green-dim": "rgba(158,255,166,0.10)",
  },
  vert: {
    "--bg": "#080a08", "--bg2": "#0c110c", "--card": "#101810", "--card-hover": "#162016",
    "--border": "rgba(80,200,100,0.1)", "--border2": "rgba(80,200,100,0.2)",
    "--text": "#e8f5e8", "--muted": "rgba(180,240,180,0.4)",
    "--amber": "#5dba7e", "--amber-dim": "rgba(93,186,126,0.1)", "--amber-dim2": "rgba(93,186,126,0.2)",
    "--green": "#9effa6", "--green-dim": "rgba(158,255,166,0.10)",
  },
  violet: {
    "--bg": "#09080a", "--bg2": "#0f0c12", "--card": "#151018", "--card-hover": "#1c1622",
    "--border": "rgba(180,80,255,0.1)", "--border2": "rgba(180,80,255,0.2)",
    "--text": "#f0e8ff", "--muted": "rgba(210,180,255,0.4)",
    "--amber": "#d946ef", "--amber-dim": "rgba(217,70,239,0.1)", "--amber-dim2": "rgba(217,70,239,0.2)",
    "--green": "#9effa6", "--green-dim": "rgba(158,255,166,0.10)",
  },
  rose: {
    "--bg": "#120a0d", "--bg2": "#1e1015", "--card": "#2a1520", "--card-hover": "#361a28",
    "--border": "rgba(251,113,133,0.1)", "--border2": "rgba(251,113,133,0.2)",
    "--text": "#ffe8ed", "--muted": "rgba(255,180,195,0.45)",
    "--amber": "#fb7185", "--amber-dim": "rgba(251,113,133,0.12)", "--amber-dim2": "rgba(251,113,133,0.22)",
    "--green": "#f472b6", "--green-dim": "rgba(244,114,182,0.12)",
  },
  cyan: {
    "--bg": "#080a0a", "--bg2": "#0c1212", "--card": "#101818", "--card-hover": "#162020",
    "--border": "rgba(6,182,212,0.1)", "--border2": "rgba(6,182,212,0.2)",
    "--text": "#e8ffff", "--muted": "rgba(150,240,255,0.4)",
    "--amber": "#06b6d4", "--amber-dim": "rgba(6,182,212,0.1)", "--amber-dim2": "rgba(6,182,212,0.2)",
    "--green": "#9effa6", "--green-dim": "rgba(158,255,166,0.10)",
  },
  or: {
    "--bg": "#0a0900", "--bg2": "#111100", "--card": "#1a1800", "--card-hover": "#222000",
    "--border": "rgba(255,200,50,0.1)", "--border2": "rgba(255,200,50,0.2)",
    "--text": "#fff8e0", "--muted": "rgba(255,240,150,0.4)",
    "--amber": "#e8a030", "--amber-dim": "rgba(232,160,48,0.1)", "--amber-dim2": "rgba(232,160,48,0.2)",
    "--green": "#9effa6", "--green-dim": "rgba(158,255,166,0.10)",
  },
};

function setTheme(name) {
  const root = document.documentElement;
  const base = themes.midnight;
  const t    = themes[name] || base;
  for (const k in base) root.style.setProperty(k, base[k]);
  for (const k in t)    root.style.setProperty(k, t[k]);
  localStorage.setItem("theme", name);
}

function updateThemeButtons() {
  const saved = localStorage.getItem("theme") || "midnight";
  document.querySelectorAll(".theme-grid button").forEach(btn => {
    btn.classList.remove("active-theme");
    if (btn.textContent.toLowerCase() === saved || btn.onclick?.toString().includes(`'${saved}'`)) {
      btn.classList.add("active-theme");
    }
  });
}

function openSettings()  { document.getElementById("settingsModal").classList.add("open"); }
function closeSettings() { document.getElementById("settingsModal").classList.remove("open"); }
document.getElementById("settingsModal").addEventListener("click", e => {
  if (e.target.id === "settingsModal") closeSettings();
});

document.getElementById("easterEgg").addEventListener("click", () => {
  const egg = document.getElementById("easterEgg");
  egg.style.transform = "scale(1.5) rotate(180deg)";
  setTimeout(() => { egg.style.transform = ""; }, 400);
});

const spotifyTracks = window.EVREN_SPOTIFY_TRACKS || [
  { file: "Song/audio1.mp3", name: "Titre audio 1 — à remplacer" },
  { file: "Song/audio2.mp3", name: "Titre audio 2 — à remplacer" },
];

let spotifyAudio   = null;
let spotifyPlaying = false;
let spotifyMuted   = false;
let spotifyLoaded  = false;

function initSpotify() {
  if (spotifyLoaded) return;
  spotifyLoaded = true;
  const track = spotifyTracks[Math.floor(Math.random() * spotifyTracks.length)];
  spotifyAudio = document.getElementById("spotifyAudio");
  spotifyAudio.src     = track.file;
  spotifyAudio.preload = "metadata";
  spotifyAudio.addEventListener("timeupdate", updateSpotifyProgress);
  spotifyAudio.addEventListener("ended", () => {
    spotifyPlaying = false;
    updateSpotifyBtn();
  });
}

function toggleSpotifyPlay() {
  if (!spotifyLoaded) initSpotify();
  if (spotifyPlaying) { spotifyAudio.pause(); spotifyPlaying = false; }
  else { spotifyAudio.play().catch(() => {}); spotifyPlaying = true; }
  updateSpotifyBtn();
}

function updateSpotifyBtn() {
  document.getElementById("spotifyPlayIcon").style.display  = spotifyPlaying ? "none"  : "block";
  document.getElementById("spotifyPauseIcon").style.display = spotifyPlaying ? "block" : "none";
  const btn = document.getElementById("musicBtn");
  if (btn) btn.classList.toggle("playing", spotifyPlaying);
}

function updateSpotifyProgress() {
}

function toggleSpotifyMute() {
  if (!spotifyAudio) { initSpotify(); return; }
  spotifyMuted = !spotifyMuted;
  spotifyAudio.muted = spotifyMuted;
}

  setTimeout(updateThemeButtons, 100);
window.addEventListener("load", () => {
  const saved = localStorage.getItem("theme") || "midnight";
  setTheme(saved);
  refreshIcons();
  setupCopyEmailButtons();
  const homeCanvas = document.getElementById("homeStarCanvas");
  if (homeCanvas) homeCanvas.classList.add("visible");
});
const roleData = window.EVREN_ROLE_DATA || {
  "script": {
    projects: ["لا تنسى", "LOIN DES FRONTIÈRES"],
    description: "En tant que scripte, j'assure le suivi de la continuité entre les scènes : raccords de jeu, de costumes, de décors et de position des acteurs.",
    images: [],
  },
  "réalisateur": {
    projects: ["UMAMI"],
    description: "En tant que réalisateur, je suis responsable de la vision artistique globale du Projet.",
    images: [
      "Images/compet/REALISATEUR/realisateur.png",
      "Images/compet/REALISATEUR/realisateur2.png",
      "Images/compet/REALISATEUR/realisateur3.png",
      "Images/compet/REALISATEUR/realisateur4.png",
    ],
  },
  "assistant réalisateur": {
    projects: ["LOIN DES FRONTIÈRES"],
    description: "En tant qu'assistant réalisateur, j'ai aidé à coordonner les équipes et à respecter le planning de tournage.",
    images: [
      "Images/compet/ASSISTANT_REALISATEUR/assistant_realisteur.png",
    ],
  },
  "scénariste": {
    projects: ["UMAMI", "لا تنسى"],
    description: "J'ai participé à l'écriture du scénario, construisant la structure narrative et les dialogues.",
    images: [
      "Images/compet/SCNENARISTE/scenariste.png",
      "Images/compet/SCNENARISTE/scenariste2.png",
      "Images/compet/SCNENARISTE/scenariste3.png",
      "Images/compet/SCNENARISTE/scenariste4.png",
    ],
  },
  "assistant ingé-son": {
    projects: ["Versatile Musique Saison 1"],
    description: "J'ai assisté l'ingénieur du son lors des prises de son sur le tournage.",
  },
  "assistant électro": {
    projects: ["UMAMI", "لا تنسى", "LOIN DES FRONTIÈRES"],
    description: "J'ai participé à l'installation et la gestion des équipements d'éclairage.",
    images: [
      "Images/compet/ASSISTANT_ELECTRO/assistant_electro.png",
      "Images/compet/ASSISTANT_ELECTRO/assistant_electro2.png",
      "Images/compet/ASSISTANT_ELECTRO/assistant_electro3.png",
      "Images/compet/ASSISTANT_ELECTRO/assistant_electro4.png",
    ],
  },
  "assistant décorateur": {
    projects: ["UMAMI"],
    description: "J'ai contribué à la préparation et à l'habillage des décors.",
  },
  "directeur de la figuration": {
    projects: ["LOIN DES FRONTIÈRES"],
    description: "J'ai géré la coordination et le placement des figurants sur les scènes.",
  },
  "assistant cam": {
    projects: ["Versatile Musique Saison 1", "LOIN DES FRONTIÈRES"],
    description: "J'ai assisté le cadreur lors des prises de vues.",
    images: [
      "Images/compet/ASSISTANT_CAM/assistant_cam.png",
      "Images/compet/ASSISTANT_CAM/assistant_cam2.png",
      "Images/compet/ASSISTANT_CAM/assistant_cam3.png",
    ],
  },
  "photographe": {
    projects: ["Versatile Musique Saison 1"],
    description: "J'ai photographié les événements et coulisses du Projet.",
    images: [
      "Images/compet/PHOTOGRAPHE_DEVENEMENT/photographe_devenement.png",
      "Images/compet/PHOTOGRAPHE_DEVENEMENT/photographe_devenement2.png",
      "Images/compet/PHOTOGRAPHE_DEVENEMENT/photographe_devenement3.png",
      "Images/compet/PHOTOGRAPHE_DEVENEMENT/photographe_devenement4.png",
      "Images/compet/PHOTOGRAPHE_DEVENEMENT/photographe_devenement5.png",
    ],
  },
};

function renderRoleGallery(images, roleName) {
  if (!images?.length) return "";

  const thumbs = images.map((src, index) => `
    <button
      class="role-shot-thumb${index === 0 ? " active" : ""}"
      type="button"
      data-role-gallery-thumb
      data-src="${src}"
      data-alt="${roleName} - aperçu ${index + 1}"
      aria-label="Voir le screenshot ${index + 1}"
    >
      <img src="${src}" alt="${roleName} - miniature ${index + 1}">
    </button>
  `).join("");

  return `
    <div class="role-shot-gallery">
      <div class="role-shot-main">
        <img
          id="roleGalleryMain"
          src="${images[0]}"
          alt="${roleName} - aperçu principal"
        >
      </div>
      <div class="role-shot-thumbs">${thumbs}</div>
    </div>
  `;
}

function bindRoleGallery() {
  const mainImg = document.getElementById("roleGalleryMain");
  if (!mainImg) return;

  document.querySelectorAll("[data-role-gallery-thumb]").forEach(button => {
    button.addEventListener("click", () => {
      mainImg.src = button.dataset.src;
      mainImg.alt = button.dataset.alt;
      document.querySelectorAll("[data-role-gallery-thumb]").forEach(thumb => thumb.classList.remove("active"));
      button.classList.add("active");
    });
  });
}

function openRoleModal(roleName) {
  const data = roleData[roleName] || {};
  document.getElementById("roleModalTag").textContent = "// role";
  document.getElementById("roleModalTitle").textContent = data.modal_title || data.label || roleName;

  const imgsEl = document.getElementById("roleModalImgs");
  const hasDescription = Boolean(data.description);
  const hasImages = Boolean(data.images?.length);
  imgsEl.innerHTML = `
    ${hasDescription ? `<p class="pmodal-desc">${data.description}</p>` : `<p class="pmodal-desc" style="color:var(--muted);">// contenu a venir</p>`}
    ${hasImages ? `<div class="role-shot-block"><div class="pmodal-roadmap-label">// screenshots & exemples</div>${renderRoleGallery(data.images, roleName)}</div>` : `<p class="pmodal-desc role-shot-empty">// screenshots a ajouter</p>`}
  `;
  bindRoleGallery();

  const projEl = document.getElementById("roleModalProjects");
  projEl.innerHTML = "";
  const projects = data.projects || [];
  if (!projects.length) {
    projEl.innerHTML = `<p class="pmodal-desc" style="color:var(--muted);">// aucun projet associe</p>`;
  } else {
    projects.forEach(name => {
      const p = document.createElement("div");
      p.className = "pmodal-roadmap-card";
      p.style.cursor = "pointer";
      p.innerHTML = `<div class="pmodal-roadmap-card-title">${name}</div>`;
      p.onclick = () => { closeRoleModal(); setTimeout(() => openProjectModal(name), 200); };
      projEl.appendChild(p);
    });
  }

  document.getElementById("roleModal").classList.add("open");
  refreshIcons();
}

function closeRoleModal() { document.getElementById("roleModal").classList.remove("open"); }
document.getElementById("roleModal")?.addEventListener("click", e => {
  if (e.target.id === "roleModal") closeRoleModal();
});
