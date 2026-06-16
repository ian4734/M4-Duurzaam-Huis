  <style>
    body {
      font-family: sans-serif;
      background: #f5f5f0;
      color: #1a1a1a;
      margin: 0;
      padding: 2rem;
    }
    h1 {
      text-align: center;
      font-size: 22px;
      font-weight: 500;
      margin-bottom: 1.5rem;
    }
    .lamp-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
      gap: 16px;
      padding: 1.5rem 0;
    }
    .lamp-card {
      background: #ffffff;
      border: 0.5px solid rgba(0,0,0,0.15);
      border-radius: 12px;
      padding: 1.25rem;
      text-align: center;
      transition: border-color 0.2s;
    }
    .lamp-card.aan {
      border-color: #EF9F27;
    }
    .lamp-bulb {
      font-size: 56px;
      line-height: 1;
      margin-bottom: 10px;
      transition: filter 0.3s, opacity 0.3s;
    }
    .lamp-card.uit .lamp-bulb {
      filter: grayscale(1);
      opacity: 0.35;
    }
    .lamp-name {
      font-size: 14px;
      font-weight: 500;
      color: #1a1a1a;
      margin-bottom: 12px;
    }
    .lamp-btn {
      border: 0.5px solid rgba(0,0,0,0.3);
      border-radius: 8px;
      padding: 7px 20px;
      font-size: 13px;
      cursor: pointer;
      background: transparent;
      color: #1a1a1a;
      transition: background 0.15s, transform 0.1s;
      width: 100%;
    }
    .lamp-btn:hover {
      background: #f0f0ea;
    }
    .lamp-btn:active {
      transform: scale(0.97);
    }
    .lamp-card.aan .lamp-btn {
      background: #FAEEDA;
      border-color: #EF9F27;
      color: #633806;
    }
    .lamp-card.aan .lamp-btn:hover {
      background: #FAC775;
    }
    .summary {
      font-size: 13px;
      color: #666;
      text-align: center;
      padding-bottom: 0.5rem;
    }
    .all-btns {
      display: flex;
      gap: 10px;
      justify-content: center;
      margin-bottom: 1.5rem;
    }
    .all-btns button {
      font-size: 13px;
      border: 0.5px solid rgba(0,0,0,0.3);
      border-radius: 8px;
      padding: 6px 16px;
      cursor: pointer;
      background: transparent;
      color: #1a1a1a;
    }
    .all-btns button:hover {
      background: #f0f0ea;
    }
  </style>

  <h1 class="h1">Lamp Schakelaar</h1>
 
  <div class="all-btns">
    <button onclick="alleAan()"><i class="ti ti-sun"></i> Alle aan</button>
    <button onclick="alleUit()"><i class="ti ti-moon"></i> Alle uit</button>
  </div>
 
  <div class="lamp-grid" id="grid"></div>
  <p class="summary" id="summary"></p>
 
  <script>
    const lampen = [
      { naam: "Woonkamer", icon: "💡" },
      { naam: "Slaapkamer", icon: "🛏️" },
      { naam: "Keuken",    icon: "🍳" },
      { naam: "Badkamer",  icon: "🚿" },
      { naam: "Gang",      icon: "🚪" },
      { naam: "Tuin",      icon: "🌿" },
    ];
    const staat = lampen.map(() => false);
 
    function render() {
      const grid = document.getElementById("grid");
      grid.innerHTML = lampen.map((l, i) => `
        <div class="lamp-card ${staat[i] ? "aan" : "uit"}">
          <div class="lamp-bulb">${l.icon}</div>
          <div class="lamp-name">${l.naam}</div>
          <button class="lamp-btn" onclick="toggle(${i})">${staat[i] ? "Uitzetten" : "Aanzetten"}</button>
        </div>
      `).join("");
      const aan = staat.filter(Boolean).length;
      document.getElementById("summary").textContent =
        aan === 0 ? "Alle lampen uit" :
        aan === lampen.length ? "Alle lampen aan" :
        `${aan} van ${lampen.length} lampen aan`;
    }
 
    function toggle(i) { staat[i] = !staat[i]; render(); }
    function alleAan()  { staat.fill(true);  render(); }
    function alleUit()  { staat.fill(false); render(); }
 
    render();
  </script>
<p>
  Ik kan via het dashboard een lamp, in het huisje, aan of uit zetten. Heeft Deon gedaan
</p>
<p>
  Ik kan op het dashboard zien of een lamp, in het huisje, aan of uit is. Heeft Kyano gedaan
</p>