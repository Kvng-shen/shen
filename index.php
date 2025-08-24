<!--
Single-file PHP + HTML + CSS + JS demo: "Ticketmaster clone" (educational sample)
Save this as index.php inside a project folder and run with: php -S localhost:8000

Features:
- Server-side PHP array of events (simulates a DB)
- Event listing with search & filters (JS)
- Event details modal & ticket purchase form (POST to same file)
- Simple confirmation and basic validation
- Responsive CSS (mobile-first)

This is an educational example — don't use in production as-is (no DB, no auth, no payment gateway).
-->

<?php
// Simple in-memory "database" of events
$events = [
    [
        'id' => 1,
        'title' => 'Summer Beats Festival',
        'date' => '2025-09-05',
        'venue' => 'Grand Park Arena',
        'city' => 'Lagos',
        'price' => 4500,
        'image' => 'https://images.unsplash.com/photo-1518600506278-4e8ef466b810?w=800&q=60'
    ],
    [
        'id' => 2,
        'title' => 'Symphony Nights',
        'date' => '2025-10-12',
        'venue' => 'Royal Hall',
        'city' => 'Ibadan',
        'price' => 8000,
        'image' => 'https://images.unsplash.com/photo-1508973372525-110c5f2077b0?w=800&q=60'
    ],
    [
        'id' => 3,
        'title' => 'Indie Live',
        'date' => '2025-09-28',
        'venue' => 'Warehouse 9',
        'city' => 'Lagos',
        'price' => 3000,
        'image' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=800&q=60'
    ],
    [
        'id' => 4,
        'title' => 'Comedy Central Night',
        'date' => '2025-11-01',
        'venue' => 'Laugh House',
        'city' => 'Abuja',
        'price' => 2500,
        'image' => 'https://images.unsplash.com/photo-1541542684-8d3f427f0f50?w=800&q=60'
    ],
];

// Handle a simple ticket purchase POST
$purchaseMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['purchase'])) {
    $eventId = intval($_POST['event_id'] ?? 0);
    $qty = intval($_POST['quantity'] ?? 1);
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    // Very basic validation
    if ($eventId <= 0 || $qty <= 0 || $name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $purchaseMessage = 'Please provide valid name, email, and quantity.';
    } else {
        // Find event
        $found = null;
        foreach ($events as $e) {
            if ($e['id'] === $eventId) { $found = $e; break; }
        }
        if (!$found) {
            $purchaseMessage = 'Event not found.';
        } else {
            $total = $found['price'] * $qty;
            // In a real app you'd create an order and redirect to payment gateway
            $purchaseMessage = "Thank you, {$name}! Your {$qty} ticket(s) for '{$found['title']}' have been reserved. Total: ₦" . number_format($total) . ". A confirmation email will be sent to {$email}. (Demo only)";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Events — Demo Ticketing</title>
  <style>
    /* Basic reset */
    *{box-sizing:border-box}
    body{font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; margin:0; background:#f5f7fb; color:#111}
    header{background:linear-gradient(90deg,#0f172a,#0b1220); color:#fff; padding:18px}
    .container{max-width:1100px; margin:20px auto; padding:0 16px}
    .brand{display:flex; align-items:center; gap:12px}
    .logo{width:44px; height:44px; background:#fff2; border-radius:8px; display:flex;align-items:center;justify-content:center; font-weight:700}
    h1{margin:0; font-size:20px}

    /* Search bar */
    .controls{display:flex; gap:12px; margin:18px 0; align-items:center; flex-wrap:wrap}
    .search{flex:1; min-width:220px}
    input[type=text], select{width:100%; padding:10px 12px; border-radius:8px; border:1px solid #e2e8f0}

    /* Grid */
    .grid{display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:16px}
    .card{background:#fff; border-radius:12px; box-shadow:0 4px 14px rgba(15,23,42,0.06); overflow:hidden}
    .thumb{height:150px; background-size:cover; background-position:center}
    .card-body{padding:12px}
    .meta{display:flex; justify-content:space-between; font-size:13px; color:#475569}
    .title{font-weight:700; margin:8px 0}
    .price{font-weight:700}
    .btn{display:inline-block; padding:8px 12px; border-radius:8px; text-decoration:none; cursor:pointer; border:0}
    .btn-primary{background:#0ea5a4; color:#fff}
    .btn-ghost{background:transparent; color:#0f172a; border:1px solid #e2e8f0}

    /* Modal */
    .modal{position:fixed; left:0; right:0; top:0; bottom:0; display:none; align-items:center; justify-content:center; background:rgba(2,6,23,0.5); padding:20px}
    .modal.open{display:flex}
    .modal-card{width:100%; max-width:760px; background:#fff; border-radius:12px; overflow:hidden; display:flex; gap:0; flex-direction:column}
    .modal-body{display:flex; gap:12px}
    .modal-image{flex:1; min-height:220px; background-size:cover; background-position:center}
    .modal-content{flex:1; padding:18px}

    /* form */
    form{display:flex; flex-direction:column; gap:8px}
    label{font-size:13px}
    input[type=number], input[type=email], input[type=text]{padding:8px 10px; border-radius:8px; border:1px solid #e6eef6}

    /* responsive */
    @media(min-width:760px){.modal-body{flex-direction:row}.modal-card{flex-direction:row}}
    footer{padding:18px; text-align:center; color:#475569}

    .notice{background:#e6fffa; color:#065f46; padding:10px; border-radius:8px; margin-bottom:12px}
  </style>
</head>
<body>
  <header>
    <div class="container brand">
      <div class="logo">ET</div>
      <div>
        <h1>EventTicket — Demo</h1>
        <div style="font-size:13px; color:#93c5fd">Buy tickets to events near you</div>
      </div>
    </div>
  </header>

  <main class="container">
    <?php if ($purchaseMessage): ?>
      <div class="notice"><?php echo htmlspecialchars($purchaseMessage); ?></div>
    <?php endif; ?>

    <div class="controls">
      <div class="search">
        <input id="searchInput" type="text" placeholder="Search events, artists, venues...">
      </div>
      <div style="width:180px">
        <select id="cityFilter">
          <option value="">All cities</option>
          <option value="Lagos">Lagos</option>
          <option value="Ibadan">Ibadan</option>
          <option value="Abuja">Abuja</option>
        </select>
      </div>
      <div style="min-width:120px">
        <select id="sortFilter">
          <option value="date_asc">Date ↑</option>
          <option value="date_desc">Date ↓</option>
          <option value="price_asc">Price ↑</option>
          <option value="price_desc">Price ↓</option>
        </select>
      </div>
    </div>

    <section id="eventsGrid" class="grid">
      <!-- Event cards rendered by JS using data from PHP -->
    </section>
  </main>

  <footer>
  </footer>

  <!-- Modal for event details and purchase -->
  <div id="modal" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-card">
      <div id="modalBody" class="modal-body">
        <div id="modalImage" class="modal-image"></div>
        <div class="modal-content">
          <h3 id="modalTitle"></h3>
          <div id="modalMeta" class="meta"></div>
          <p id="modalVenue"></p>

          <form id="purchaseForm" method="POST">
            <input type="hidden" name="event_id" id="formEventId">
            <label>Full name <input type="text" name="name" required></label>
            <label>Email <input type="email" name="email" required></label>
            <label>Quantity <input type="number" name="quantity" value="1" min="1" required></label>
            <div style="display:flex; gap:8px; margin-top:8px">
              <button type="submit" name="purchase" class="btn btn-primary">Reserve tickets</button>
              <button type="button" id="closeModal" class="btn btn-ghost">Cancel</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>

  <script>
    // Pass PHP $events to JS safely
    const EVENTS = <?php echo json_encode($events, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP); ?>;

    const eventsGrid = document.getElementById('eventsGrid');
    const searchInput = document.getElementById('searchInput');
    const cityFilter = document.getElementById('cityFilter');
    const sortFilter = document.getElementById('sortFilter');

    function formatPrice(n){ return '$' + n.toLocaleString(); }

    function renderCards(list){
      eventsGrid.innerHTML = '';
      if(list.length === 0){ eventsGrid.innerHTML = '<div style="grid-column:1/-1; padding:28px; text-align:center; color:#64748b">No events found</div>'; return; }
      list.forEach(e => {
        const card = document.createElement('article');
        card.className = 'card';
        card.innerHTML = `
          <div class="thumb" style="background-image:url(${e.image})"></div>
          <div class="card-body">
            <div class="meta"><div>${e.date}</div><div class="price">${formatPrice(e.price)}</div></div>
            <div class="title">${e.title}</div>
            <div style="display:flex;justify-content:space-between;align-items:center">
              <div style="font-size:13px;color:#64748b">${e.venue} • ${e.city}</div>
              <button class="btn btn-primary" onclick="openModal(${e.id})">Buy</button>
            </div>
          </div>
        `;
        eventsGrid.appendChild(card);
      });
    }

    function filterAndSort(){
      const q = searchInput.value.trim().toLowerCase();
      const city = cityFilter.value;
      let out = EVENTS.filter(e => {
        const matchQ = e.title.toLowerCase().includes(q) || e.venue.toLowerCase().includes(q) || e.city.toLowerCase().includes(q);
        const matchCity = city ? e.city === city : true;
        return matchQ && matchCity;
      });
      const sort = sortFilter.value;
      out.sort((a,b)=>{
        if(sort === 'date_asc') return new Date(a.date)-new Date(b.date);
        if(sort === 'date_desc') return new Date(b.date)-new Date(a.date);
        if(sort === 'price_asc') return a.price - b.price;
        if(sort === 'price_desc') return b.price - a.price;
        return 0;
      });
      renderCards(out);
    }

    // initial render
    filterAndSort();

    searchInput.addEventListener('input', debounce(filterAndSort, 250));
    cityFilter.addEventListener('change', filterAndSort);
    sortFilter.addEventListener('change', filterAndSort);

    // modal logic
    const modal = document.getElementById('modal');
    const modalTitle = document.getElementById('modalTitle');
    const modalMeta = document.getElementById('modalMeta');
    const modalVenue = document.getElementById('modalVenue');
    const modalImage = document.getElementById('modalImage');
    const formEventId = document.getElementById('formEventId');

    function openModal(id){
      const e = EVENTS.find(x=>x.id===id);
      if(!e) return;
      modalTitle.textContent = e.title;
      modalMeta.innerHTML = `<div>${e.date}</div><div class="price">${formatPrice(e.price)}</div>`;
      modalVenue.textContent = `${e.venue} • ${e.city}`;
      modalImage.style.backgroundImage = `url(${e.image})`;
      formEventId.value = e.id;
      modal.classList.add('open');
      modal.setAttribute('aria-hidden','false');
    }
    document.getElementById('closeModal').addEventListener('click', ()=>{ modal.classList.remove('open'); modal.setAttribute('aria-hidden','true'); });
    modal.addEventListener('click', (ev)=>{ if(ev.target===modal) { modal.classList.remove('open'); modal.setAttribute('aria-hidden','true'); } });

    // simple debounce fn
    function debounce(fn, wait){ let t; return function(...a){ clearTimeout(t); t = setTimeout(()=>fn.apply(this,a), wait); } }

  </script>
</body>
</html>
