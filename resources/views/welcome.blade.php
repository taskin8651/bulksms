

           <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TextWave — Bulk SMS & Web Mail API</title>
  <meta name="description" content="DLT‑compliant Bulk SMS & Web Mail provider with OTP, promotional & transactional routes. Simple API, real‑time reports, and transparent pricing." />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
          colors: {
            primary: {
              50: '#eff6ff',
              100: '#dbeafe',
              200: '#bfdbfe',
              300: '#93c5fd',
              400: '#60a5fa',
              500: '#3b82f6',
              600: '#2563eb',
              700: '#1d4ed8',
              800: '#1e40af',
              900: '#1e3a8a'
            }
          },
          boxShadow: {
            soft: '0 10px 30px rgba(2, 6, 23, 0.06)'
          }
        }
      }
    }
  </script>
  <style>
    .glass { backdrop-filter: saturate(140%) blur(8px); }
    .section { scroll-margin-top: 90px; }
  </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
  <!-- Top Notice -->
  <div class="bg-primary-600 text-white text-center text-sm py-2">DLT‑compliant • Free sender ID* • 99.9% uptime • India & Global routes</div>

  <!-- Navbar -->
  <header class="sticky top-0 z-50 bg-white/80 glass border-b border-slate-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <a href="#" class="flex items-center gap-2">
          <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary-600 text-white font-bold">TW</span>
          <span class="font-extrabold tracking-tight text-lg">TextWave</span>
        </a>
        <nav class="hidden md:flex items-center gap-8 font-medium text-slate-700">
          <a href="#features" class="hover:text-primary-700">Features</a>
          <a href="#pricing" class="hover:text-primary-700">Pricing</a>
          <a href="#api" class="hover:text-primary-700">API</a>
          <a href="#contact" class="hover:text-primary-700">Contact</a>
        </nav>
        <div class="hidden md:flex items-center gap-3">
         @if (Route::has('login'))
    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
        @auth
            <!-- Dropdown for user name & logout -->
            <div class="relative inline-block text-left">
                <button class="px-4 py-2 text-sm rounded-xl border border-slate-300 hover:bg-slate-100">
                    {{ Auth::user()->name }}
                </button>
                <div class="absolute right-0 mt-2 w-40 bg-white border rounded-xl shadow-lg hidden group-hover:block">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-slate-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        @else
            <!-- Only Sign in button -->
            <a href="{{ route('login') }}"
               class="px-4 py-2 text-sm rounded-xl border border-slate-300 hover:bg-slate-100">
                Sign in
            </a>
        @endauth
    </div>
@endif

          <a href="#" class="px-4 py-2 text-sm rounded-xl border border-slate-300 hover:bg-slate-100">Sign in</a>
          <a href="#contact" class="px-4 py-2 text-sm rounded-xl bg-primary-600 text-white hover:bg-primary-700 shadow-soft">Get started</a>
        </div>
        <button id="menuBtn" class="md:hidden inline-flex items-center justify-center h-10 w-10 rounded-xl border border-slate-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>
    <div id="mobileMenu" class="md:hidden hidden border-t border-slate-200 bg-white">
      <div class="px-4 py-4 flex flex-col gap-3">
        <a href="#features" class="py-2">Features</a>
        <a href="#pricing" class="py-2">Pricing</a>
        <a href="#api" class="py-2">API</a>
        <a href="#contact" class="py-2">Contact</a>
        <div class="pt-2 flex gap-3">
          <a href="#" class="flex-1 text-center px-4 py-2 text-sm rounded-xl border border-slate-300">Sign in</a>
          <a href="#contact" class="flex-1 text-center px-4 py-2 text-sm rounded-xl bg-primary-600 text-white">Get started</a>
        </div>
      </div>
    </div>
  </header>

  <!-- Hero -->
  <section class="section" id="home">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 grid lg:grid-cols-2 gap-12">
      <div class="flex flex-col justify-center">
        <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight tracking-tight">
          Send OTP, Promotional SMS & Web Mail in <span class="text-primary-700">seconds</span>
        </h1>
        <p class="mt-5 text-lg text-slate-700">A single, blazing‑fast dashboard and API for Bulk SMS and Email. DLT‑ready for India, with real‑time delivery reports, templates, and smart scheduling.</p>
        <div class="mt-7 flex items-center gap-3">
          <a href="#pricing" class="px-5 py-3 rounded-2xl bg-primary-600 text-white font-medium hover:bg-primary-700 shadow-soft">View pricing</a>
          <a href="#api" class="px-5 py-3 rounded-2xl border border-slate-300 font-medium hover:bg-slate-100">Read API docs</a>
        </div>
        <div class="mt-6 flex items-center gap-4 text-sm text-slate-600">
          <div class="flex items-center gap-2"><span class="inline-block h-2.5 w-2.5 rounded-full bg-green-500"></span> 99.9% uptime</div>
          <div class="flex items-center gap-2"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 12l2 2 4-4M7.8 4.2h8.4a2 2 0 012 2v11.6a2 2 0 01-2 2H7.8a2 2 0 01-2-2V6.2a2 2 0 012-2z"/></svg> DLT compliant</div>
          <div class="flex items-center gap-2"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 8v8m4-4H8"/></svg> Free sender ID*</div>
        </div>
      </div>
      <div class="relative">
        <div class="absolute -inset-6 lg:-inset-8 bg-gradient-to-tr from-primary-200 via-white to-primary-50 rounded-3xl blur-2xl"></div>
        <div class="relative bg-white border border-slate-200 rounded-3xl shadow-soft p-6">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <span class="h-10 w-10 inline-flex items-center justify-center rounded-2xl bg-primary-600 text-white font-bold">TW</span>
              <div class="font-semibold">Quick Campaign</div>
            </div>
            <span class="text-xs px-2 py-1 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200">LIVE</span>
          </div>
          <div class="mt-5 grid gap-4">
            <input type="text" placeholder="Sender ID (e.g., TXTWAV)" class="w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500" />
            <textarea rows="4" placeholder="Type your message…" class="w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500"></textarea>
            <input type="text" placeholder="Upload CSV or paste numbers: 98765xxxxx, 98765xxxxx" class="w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500" />
            <div class="flex items-center justify-between text-sm">
              <div class="text-slate-600">160 chars = 1 SMS • Unicode supported</div>
              <button class="px-4 py-2 rounded-xl bg-primary-600 text-white hover:bg-primary-700">Send test</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Logos -->
  <section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 opacity-80">
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-6 place-items-center">
        <div class="text-xs uppercase tracking-wider">Trusted by 5,000+ teams</div>
        <div class="h-8 w-28 bg-slate-200 rounded"></div>
        <div class="h-8 w-28 bg-slate-200 rounded"></div>
        <div class="h-8 w-28 bg-slate-200 rounded"></div>
        <div class="h-8 w-28 bg-slate-200 rounded"></div>
        <div class="h-8 w-28 bg-slate-200 rounded"></div>
      </div>
    </div>
  </section>

  <!-- Features -->
  <section id="features" class="section py-16 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center max-w-2xl mx-auto">
        <h2 class="text-3xl sm:text-4xl font-extrabold">Everything you need to deliver at scale</h2>
        <p class="mt-4 text-slate-600">From OTP to marketing campaigns—manage SMS and Email from a single dashboard and API.</p>
      </div>
      <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Card -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-soft">
          <div class="h-10 w-10 rounded-2xl bg-primary-600/10 text-primary-700 inline-flex items-center justify-center mb-4">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4m16 0H4"/></svg>
          </div>
          <h3 class="font-bold text-lg">Single‑page dashboard</h3>
          <p class="mt-2 text-slate-600">Compose, upload contacts, schedule, and send—all without leaving the page.</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-soft">
          <div class="h-10 w-10 rounded-2xl bg-primary-600/10 text-primary-700 inline-flex items-center justify-center mb-4">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7"/></svg>
          </div>
          <h3 class="font-bold text-lg">Email & SMS together</h3>
          <p class="mt-2 text-slate-600">Run multi‑channel campaigns from the same UI. Perfect for OTP + transactional mail receipts.</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-soft">
          <div class="h-10 w-10 rounded-2xl bg-primary-600/10 text-primary-700 inline-flex items-center justify-center mb-4">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 8v8m4-4H8"/></svg>
          </div>
          <h3 class="font-bold text-lg">DLT & templates</h3>
          <p class="mt-2 text-slate-600">Pre‑approved templates, sender IDs, and scrubbing to comply with TRAI regulations.</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-soft">
          <div class="h-10 w-10 rounded-2xl bg-primary-600/10 text-primary-700 inline-flex items-center justify-center mb-4">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M11 5l-7 7 7 7M5 12h14"/></svg>
          </div>
          <h3 class="font-bold text-lg">Real‑time DLR</h3>
          <p class="mt-2 text-slate-600">Track deliveries, failures, and retries with operator‑level insights.</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-soft">
          <div class="h-10 w-10 rounded-2xl bg-primary-600/10 text-primary-700 inline-flex items-center justify-center mb-4">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 6v6l4 2"/></svg>
          </div>
          <h3 class="font-bold text-lg">Scheduling & drip</h3>
          <p class="mt-2 text-slate-600">Schedule campaigns, set throttling, and build drip sequences in minutes.</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-soft">
          <div class="h-10 w-10 rounded-2xl bg-primary-600/10 text-primary-700 inline-flex items-center justify-center mb-4">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M5 12h14M12 5l7 7-7 7"/></svg>
          </div>
          <h3 class="font-bold text-lg">Powerful API</h3>
          <p class="mt-2 text-slate-600">Simple REST endpoints & API keys—send OTP, templates, and attachments (email).</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Pricing -->
  <section id="pricing" class="section py-16 lg:py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center max-w-2xl mx-auto">
        <h2 class="text-3xl sm:text-4xl font-extrabold">Simple, transparent pricing</h2>
        <p class="mt-3 text-slate-600">Pay as you grow. No setup fees. GST extra as applicable.</p>
        <!-- Toggle -->
        <div class="mt-6 inline-flex items-center gap-3 rounded-2xl border border-slate-200 p-1">
          <button id="monthlyBtn" class="px-4 py-2 rounded-xl text-sm font-medium bg-white">Monthly</button>
          <button id="annualBtn" class="px-4 py-2 rounded-xl text-sm font-medium text-slate-600">Annual <span class="ml-1 inline-block text-[10px] px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">Save 15%</span></button>
        </div>
      </div>

      <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Starter -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-soft flex flex-col">
          <h3 class="font-bold text-lg">Starter</h3>
          <p class="mt-1 text-sm text-slate-600">For side projects</p>
          <div class="mt-5 flex items-end gap-1">
            <div class="price text-4xl font-extrabold" data-monthly="₹499" data-annual="₹5,085">₹499</div>
            <div class="text-slate-500 mb-2 text-sm">/mo</div>
          </div>
          <ul class="mt-4 space-y-3 text-sm text-slate-700">
            <li>⚡ 5,000 SMS / month</li>
            <li>✉️ 10,000 emails / month</li>
            <li>🔐 1 sender ID</li>
            <li>📊 Basic analytics</li>
            <li>🧩 API access</li>
          </ul>
          <a href="#contact" class="mt-6 inline-flex justify-center px-4 py-2 rounded-xl bg-primary-600 text-white hover:bg-primary-700">Start free</a>
        </div>
        <!-- Growth -->
        <div class="bg-white border-2 border-primary-600 rounded-3xl p-6 shadow-soft flex flex-col relative">
          <span class="absolute -top-3 right-4 text-[11px] px-2 py-0.5 rounded-full bg-primary-600 text-white">Popular</span>
          <h3 class="font-bold text-lg">Growth</h3>
          <p class="mt-1 text-sm text-slate-600">For startups & SMBs</p>
          <div class="mt-5 flex items-end gap-1">
            <div class="price text-4xl font-extrabold" data-monthly="₹1,999" data-annual="₹20,391">₹1,999</div>
            <div class="text-slate-500 mb-2 text-sm">/mo</div>
          </div>
          <ul class="mt-4 space-y-3 text-sm text-slate-700">
            <li>⚡ 25,000 SMS / month</li>
            <li>✉️ 50,000 emails / month</li>
            <li>🔐 3 sender IDs</li>
            <li>📊 Advanced analytics & webhooks</li>
            <li>🧩 Priority API throughput</li>
          </ul>
          <a href="#contact" class="mt-6 inline-flex justify-center px-4 py-2 rounded-xl bg-primary-600 text-white hover:bg-primary-700">Choose Growth</a>
        </div>
        <!-- Scale -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-soft flex flex-col">
          <h3 class="font-bold text-lg">Scale</h3>
          <p class="mt-1 text-sm text-slate-600">For high‑volume teams</p>
          <div class="mt-5 flex items-end gap-1">
            <div class="price text-4xl font-extrabold" data-monthly="₹6,999" data-annual="₹71,379">₹6,999</div>
            <div class="text-slate-500 mb-2 text-sm">/mo</div>
          </div>
          <ul class="mt-4 space-y-3 text-sm text-slate-700">
            <li>⚡ 100,000 SMS / month</li>
            <li>✉️ 200,000 emails / month</li>
            <li>🔐 5 sender IDs + sub‑accounts</li>
            <li>📊 Operator‑level DLR insights</li>
            <li>🧩 Dedicated IP (email)</li>
          </ul>
          <a href="#contact" class="mt-6 inline-flex justify-center px-4 py-2 rounded-xl bg-primary-600 text-white hover:bg-primary-700">Go Scale</a>
        </div>
        <!-- Enterprise -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-soft flex flex-col">
          <h3 class="font-bold text-lg">Enterprise</h3>
          <p class="mt-1 text-sm text-slate-600">Custom SLAs & support</p>
          <div class="mt-5 flex items-end gap-1">
            <div class="text-3xl font-extrabold">Talk to us</div>
          </div>
          <ul class="mt-4 space-y-3 text-sm text-slate-700">
            <li>⚡ Millions of SMS / day</li>
            <li>✉️ Custom email throughput</li>
            <li>🔐 Dedicated routes & IPs</li>
            <li>📊 24×7 support • SSO • SAML</li>
            <li>🧩 On‑prem / VPC options</li>
          </ul>
          <a href="#contact" class="mt-6 inline-flex justify-center px-4 py-2 rounded-xl bg-primary-600 text-white hover:bg-primary-700">Contact sales</a>
        </div>
      </div>

      <p class="mt-6 text-center text-xs text-slate-500">*Free sender ID subject to DLT approval & fair‑use policy. SMS credits billed per segment. Email pricing based on monthly send limits.</p>
    </div>
  </section>

  <!-- API Section -->
  <section id="api" class="section py-16 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-10">
      <div>
        <h2 class="text-3xl sm:text-4xl font-extrabold">Developer‑friendly API</h2>
        <p class="mt-4 text-slate-600">Authenticate with API keys and start sending in minutes. Webhooks for delivery, bounces, and replies.</p>
        <ul class="mt-6 space-y-3 text-slate-700">
          <li>• REST endpoints for SMS send, template send, OTP verify</li>
          <li>• Email send with attachments (up to 25 MB)</li>
          <li>• Webhooks: delivered, failed, opened (email), clicked (email)</li>
          <li>• SDKs: PHP, Node.js, Python (coming soon)</li>
        </ul>
      </div>
      <div class="bg-slate-900 text-slate-100 rounded-2xl p-5 shadow-soft border border-slate-800">
        <div class="text-xs uppercase tracking-wider text-slate-400">Example</div>
        <pre class="mt-2 overflow-x-auto text-sm"><code>// Send SMS (cURL)
curl -X POST https://api.textwave.in/v1/sms/send \
  -H "Authorization: Bearer &lt;API_KEY&gt;" \
  -H "Content-Type: application/json" \
  -d '{
    "sender": "TXTWAV",
    "to": ["919876543210", "919123456789"],
    "template_id": "120716xxx",
    "vars": {"name": "Taskin", "otp": "482913"}
  }'

// Send Email (Node.js)
await fetch('https://api.textwave.in/v1/email/send', {
  method: 'POST',
  headers: {
    'Authorization': 'Bearer &lt;API_KEY&gt;',
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    from: { name: 'TextWave', email: 'no-reply@textwave.in' },
    to: ['taskin@example.com'],
    subject: 'Welcome to TextWave',
    html: '<h1>Hello!</h1><p>Your account is ready.</p>'
  })
});</code></pre>
      </div>
    </div>
  </section>

  <!-- Testimonials / Stats -->
  <section class="py-16 lg:py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-3 gap-6">
      <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-soft">
        <div class="text-4xl font-extrabold">&lt; 2s</div>
        <p class="mt-2 text-slate-600">Average OTP delivery time</p>
      </div>
      <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-soft">
        <div class="text-4xl font-extrabold">99.9%</div>
        <p class="mt-2 text-slate-600">Uptime backed by SLA</p>
      </div>
      <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-soft">
        <div class="text-4xl font-extrabold">5,000+</div>
        <p class="mt-2 text-slate-600">Businesses onboarded</p>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section class="py-16 lg:py-24 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-3xl sm:text-4xl font-extrabold text-center">FAQs</h2>
      <div class="mt-10 divide-y divide-slate-200 border border-slate-200 rounded-2xl overflow-hidden">
        <details class="group p-6">
          <summary class="flex cursor-pointer list-none items-center justify-between font-medium">What is DLT compliance?<span class="transition group-open:rotate-180">⌄</span></summary>
          <p class="mt-3 text-slate-600">Distributed Ledger Technology mandated by TRAI for commercial SMS in India. We help register headers & templates and validate every message to ensure compliance.</p>
        </details>
        <details class="group p-6">
          <summary class="flex cursor-pointer list-none items-center justify-between font-medium">Do you provide a free trial?<span class="transition group-open:rotate-180">⌄</span></summary>
          <p class="mt-3 text-slate-600">Yes, sign up to receive test credits for SMS and Email. KYC is required to go live.</p>
        </details>
        <details class="group p-6">
          <summary class="flex cursor-pointer list-none items-center justify-between font-medium">How are SMS billed?<span class="transition group-open:rotate-180">⌄</span></summary>
          <p class="mt-3 text-slate-600">Per 160‑character segment for GSM‑7. Unicode and long messages may consume multiple segments.</p>
        </details>
        <details class="group p-6">
          <summary class="flex cursor-pointer list-none items-center justify-between font-medium">Can I use my email domain?<span class="transition group-open:rotate-180">⌄</span></summary>
          <p class="mt-3 text-slate-600">Yes. Add DNS records (SPF, DKIM, DMARC) to enable trusted sending and top inbox placement.</p>
        </details>
      </div>
    </div>
  </section>

  <!-- Contact / Signup -->
  <section id="contact" class="section py-16 lg:py-24 bg-gradient-to-b from-white to-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-10">
      <div>
        <h2 class="text-3xl sm:text-4xl font-extrabold">Start sending today</h2>
        <p class="mt-4 text-slate-600">Tell us a bit about your use‑case and we’ll set you up with the right route and pricing.</p>
        <ul class="mt-6 space-y-3 text-slate-700">
          <li>• Go live in 24 hours post‑KYC</li>
          <li>• Free onboarding & template mapping</li>
          <li>• 24×7 chat & email support</li>
        </ul>
      </div>
      <form class="bg-white border border-slate-200 rounded-2xl p-6 shadow-soft grid grid-cols-1 gap-4">
        <div class="grid sm:grid-cols-2 gap-4">
          <div>
            <label class="text-sm font-medium">Full name</label>
            <input type="text" required class="mt-1 w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500" placeholder="Taskin Ahmed" />
          </div>
          <div>
            <label class="text-sm font-medium">Work email</label>
            <input type="email" required class="mt-1 w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500" placeholder="you@company.com" />
          </div>
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
          <div>
            <label class="text-sm font-medium">Phone</label>
            <input type="tel" class="mt-1 w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500" placeholder="+91 98765 43210" />
          </div>
          <div>
            <label class="text-sm font-medium">Company</label>
            <input type="text" class="mt-1 w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500" placeholder="Your Company Pvt Ltd" />
          </div>
        </div>
        <div>
          <label class="text-sm font-medium">What do you want to send?</label>
          <select class="mt-1 w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500">
            <option>OTP / Transactional SMS</option>
            <option>Promotional SMS</option>
            <option>Transactional Email</option>
            <option>Marketing Email</option>
            <option>Both SMS & Email</option>
          </select>
        </div>
        <div>
          <label class="text-sm font-medium">Message</label>
          <textarea rows="4" class="mt-1 w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500" placeholder="Share your monthly volume, use‑case, preferred routes…"></textarea>
        </div>
        <div class="flex items-center justify-between">
          <label class="inline-flex items-center gap-2 text-sm text-slate-600"><input type="checkbox" class="rounded border-slate-300"/> I agree to the Terms & Privacy</label>
          <button type="submit" class="px-5 py-3 rounded-2xl bg-primary-600 text-white font-medium hover:bg-primary-700">Request demo</button>
        </div>
      </form>
    </div>
  </section>

  <!-- Footer -->
  <footer class="border-t border-slate-200 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid md:grid-cols-2 gap-6 items-center">
      <div class="text-sm text-slate-600">© <span id="year"></span> TextWave Technologies. All rights reserved.</div>
      <div class="flex md:justify-end gap-6 text-sm">
        <a href="#" class="hover:text-primary-700">Terms</a>
        <a href="#" class="hover:text-primary-700">Privacy</a>
        <a href="#contact" class="hover:text-primary-700">Contact</a>
      </div>
    </div>
  </footer>

  <script>
    // Mobile menu
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    if (menuBtn) menuBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));

    // Pricing toggle
    const monthlyBtn = document.getElementById('monthlyBtn');
    const annualBtn = document.getElementById('annualBtn');
    const prices = document.querySelectorAll('.price');

    function setMode(mode) {
      if (mode === 'monthly') {
        monthlyBtn.classList.add('bg-white');
        monthlyBtn.classList.remove('text-slate-600');
        annualBtn.classList.remove('bg-white');
        annualBtn.classList.add('text-slate-600');
        prices.forEach(p => p.textContent = p.dataset.monthly);
      } else {
        annualBtn.classList.add('bg-white');
        annualBtn.classList.remove('text-slate-600');
        monthlyBtn.classList.remove('bg-white');
        monthlyBtn.classList.add('text-slate-600');
        prices.forEach(p => p.textContent = p.dataset.annual);
      }
      window.localStorage.setItem('billingMode', mode);
    }

    const saved = window.localStorage.getItem('billingMode') || 'monthly';
    setMode(saved);
    monthlyBtn.addEventListener('click', () => setMode('monthly'));
    annualBtn.addEventListener('click', () => setMode('annual'));

    // Year
    document.getElementById('year').textContent = new Date().getFullYear();
  </script>
</body>
</html>
