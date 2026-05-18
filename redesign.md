# JARSIPLUS v2 — Redesign Plan

Dokumen ini adalah blueprint redesign UI JARSIPLUS v2 berdasarkan dua template PrimeVue Premium:

- **Frontend (publik / pre-login):** [Genesis](https://genesis.primevue.org/) — multipurpose landing
- **Backend (panel semua role):** [Diamond](https://diamond.primevue.org/) — admin panel komprehensif

Target: tampilan profesional, konsisten, dan production-ready untuk semua role (Pemohon, Pembahas, Evaluator, Administrator, Superadmin).

---

## 1. Pemisahan Layout

### 1.1. Public Layout (Genesis-style)
Halaman publik yang **boleh diakses tanpa login**.

**Halaman:**
- `/` — Landing page (hero, fitur, CTA, jadwal pengajuan, statistik publik)
- `/about` — Tentang JARSIPLUS
- `/faq` — FAQ
- `/laman/{slug}` — CMS pages dari tabel `laman`
- `/inovasi` — Galeri inovasi yang sudah disetujui (publik)
- `/inovasi/{slug}` — Detail inovasi publik
- `/contact` — Kontak / hubungi kami
- `/404`, `/maintenance`

**Karakter visual:**
- Hero gradient + cloud assets dari Genesis (atau ilustrasi inovasi Samarinda)
- Palette warna brand: `#222831` `#393E46` `#00ADB5` `#EEEEEE`
- Typography display besar untuk hero, body modern (Inter / Manrope)
- CTA tombol prominent: "Ajukan Inovasi" → `/login`
- Section: features grid, statistik (jumlah inovasi, pemohon, kategori), testimonial / dukungan stakeholder, footer dengan navigasi lengkap

**File Vue baru:**
```
resources/js/Layouts/PublicLayout.vue
resources/js/Pages/Public/
├── Welcome.vue           (landing)
├── About.vue
├── Faq.vue
├── Laman.vue             (dynamic CMS page)
├── Inovasi/
│   ├── Index.vue         (galeri publik)
│   └── Show.vue          (detail publik)
├── Contact.vue
└── Errors/
    ├── 404.vue
    └── Maintenance.vue
```

**Komponen Genesis yang diadopsi:**
- Hero section dengan parallax / cloud animation
- Feature grid 4 kolom dengan icon + judul + deskripsi
- Image gallery scrolling untuk showcase inovasi
- "Plan Your Holiday" → adaptasi jadi "Cara Mengajukan Inovasi" (4 langkah)
- Footer dengan kolom navigasi (Inovasi, Tentang, Bantuan, Kontak)

---

### 1.2. Admin Layout (Diamond-style)
Panel yang **hanya boleh diakses setelah login SSO** — untuk semua role.

**Karakter visual:**
- Monochrome / minimal (hitam-putih + 1 accent neutral)
- Sidebar collapsible kiri dengan menu hierarchy dari DB
- Topbar tipis dengan: logo, breadcrumb, search global, notifications, user menu, theme toggle
- Content area max-width fluid, padding konsisten 1rem
- Card dengan border `#e4e4e7` (zinc-200), tidak shadow heavy
- Typography compact: `text-xs` body, `text-sm` heading section, `text-lg` page title

**Struktur layout (Diamond):**
```
┌─────────────────────────────────────────────────────────┐
│  [≡] JARSIPLUS    [breadcrumb]    [🔍] [🔔] [👤 ▼]    │ ← Topbar 48px
├──────┬──────────────────────────────────────────────────┤
│      │                                                  │
│ Side │   Page Title                                     │
│ bar  │   Breadcrumb · Description                       │
│      │                                                  │
│ Menu │   ┌────────┬────────┬────────┬────────┐        │
│ tree │   │ Stat 1 │ Stat 2 │ Stat 3 │ Stat 4 │        │
│      │   └────────┴────────┴────────┴────────┘        │
│ 224px│                                                  │
│      │   ┌──────────────────────────────────┐          │
│      │   │  DataTable / Form / Detail        │          │
│      │   └──────────────────────────────────┘          │
└──────┴──────────────────────────────────────────────────┘
```

**File Vue:**
```
resources/js/Layouts/AdminLayout.vue   (UPDATE: monochrome, tight)
resources/js/Components/Admin/
├── AppSidebar.vue
├── AppTopbar.vue
├── AppBreadcrumb.vue
├── AppSearch.vue
├── AppNotifications.vue
├── AppUserMenu.vue
├── PageHeader.vue
├── StatCard.vue
└── DataTableCard.vue
```

**Komponen Diamond yang diadopsi:**
- Sidebar dengan section header (Operations, Master, Reports, Settings)
- Topbar pencarian command-palette style (Ctrl+K)
- Notification dropdown dengan unread badge
- User menu dengan avatar, role badge, profile/settings/logout
- Crumb navigation otomatis dari route
- Stat card dengan trend indicator
- DataTable header sticky, filter inline, action column sticky kanan
- Empty state dengan icon + CTA

---

## 2. Mapping Halaman per Role

> **Catatan:** Role **Evaluator/Juri tidak ada di JARSIPLUS** sebagai user internal. Penilaian dari juri di-fetch read-only via API eksternal dan ditampilkan sebagai data tambahan di detail permohonan untuk Pembahas/Admin.

### Pemohon
**Dapat akses:**
- `/dashboard` — ringkasan permohonan saya, progres, jadwal
- `/permohonan` — list permohonan saya (filter status, tahun)
- `/permohonan/create` — wizard 4 step (Info Dasar → Detail Inovasi → Indikator → File Pendukung)
- `/permohonan/{id}` — detail (read-only kecuali status `draft`)
- `/permohonan/{id}/edit` — edit draft
- `/profil` — profil pemohon (edit data diri, NIP, jabatan, unit kerja, foto)
- `/notifikasi` — inbox notifikasi
- `/jadwal` — info jadwal pengajuan (`app_settings`)

### Pembahas
**Tambahan dari Pemohon (tidak punya `/permohonan/create`):**
- `/pembahasan` — list permohonan yang ditugaskan untuk dibahas
- `/pembahasan/{id}` — form pembahasan + validasi (`permohonan_histori_pembahasan_validasi`)
- `/laporan/pembahasan` — laporan hasil pembahasan saya
- Detail permohonan menampilkan section "Penilaian Juri" yang di-fetch read-only dari API juri eksternal

### Administrator
**Tambahan untuk manage seluruh sistem:**
- `/admin/permohonan` — semua permohonan (semua status, semua tahun)
- `/admin/pemohon` — manage pemohon
- `/admin/users` — manage users + role assignment
- `/admin/master/indikator` — CRUD indikator
- `/admin/master/parameter` — CRUD parameter
- `/admin/master/urusan` — CRUD urusan + kategori
- `/admin/master/wilayah` — CRUD provinsi/kota/kecamatan
- `/admin/cms/laman` — CRUD halaman CMS
- `/admin/cms/faq` — CRUD FAQ
- `/admin/cms/slider` — CRUD slider home
- `/admin/log/aktivitas` — `user_activities`
- `/admin/log/notifikasi` — `notification_logs`
- `/admin/pengaturan/jadwal` — buka/tutup pengajuan via `app_settings`
- `/admin/pengaturan/sistem` — settings umum
- `/admin/laporan/inovasi` — laporan rekap (export Excel/PDF)
- `/admin/laporan/dashboard-statistik` — chart statistik

### Superadmin
**Tambahan dari Administrator:**
- `/admin/roles` — CRUD roles
- `/admin/permissions` — CRUD permissions
- `/admin/menu` — CRUD menu (drag-drop tree)
- `/admin/pengaturan/integrasi` — config WhatsApp / Juri / Monografi / SSO

---

## 3. Komponen UI Prinsip

### 3.1. Form (PrimeVue + custom)
- `InputText`, `Textarea` (autoResize), `Select` (with filter), `MultiSelect`, `DatePicker`, `InputNumber`, `RadioButton`, `Checkbox`, `FileUpload`
- Semua `size="small"` di admin panel
- Label `text-xs font-medium text-zinc-700`
- Error message `text-[11px] text-red-600`
- Hint message `text-[11px] text-zinc-500`
- Wizard form pakai `Stepper`

### 3.2. Data Display
- `DataTable` lazy + paginator + global filter + column toggle + export
- Status pakai `Tag` dengan severity konsisten:
  - draft → secondary, submitted → info, reviewed → warn, approved → success, rejected → danger
- Action column sticky kanan dengan tombol icon-only (Show/Edit/Delete)
- Empty state dengan `pi pi-inbox` + CTA

### 3.3. Feedback
- `Toast` untuk flash success/error (auto-dismiss 3 detik)
- `ConfirmDialog` untuk destructive actions (delete, submit)
- `Skeleton` untuk loading state
- `ProgressBar` untuk upload progress
- Inline `Message` untuk inline form errors

### 3.4. Navigation
- Sidebar `PanelMenu` dengan icon `pi *`
- Topbar breadcrumb otomatis dari route name
- Tab navigation untuk halaman dengan banyak section (`Tabs` PrimeVue)
- Quick actions dropdown di topbar

---

## 4. Theme & Tokens

### 4.1. Public (Brand Colors)
```js
// Genesis-style, digunakan HANYA di PublicLayout
brand: {
  primary:   '#222831',  // dark
  secondary: '#393E46',  // gray
  accent:    '#00ADB5',  // teal
  surface:   '#EEEEEE',  // light
}
```

### 4.2. Admin (Monochrome Neutral)
```js
// Diamond-style monochrome
neutral: {
  50:  '#fafafa',  // lightest bg
  100: '#f4f4f5',  // alt bg, hover
  200: '#e4e4e7',  // border
  300: '#d4d4d8',
  400: '#a1a1aa',  // muted
  500: '#71717a',  // helper
  600: '#52525b',
  700: '#3f3f46',  // body text
  800: '#27272a',
  900: '#18181b',  // emphasis text, primary action
  950: '#09090b',
}
```

PrimeVue preset: `definePreset(Aura, { semantic: { primary: { 500-950: neutral.500-950 } } })` — sudah diimplementasikan di `app.js`.

### 4.3. Typography
- Font: `Inter` (default) atau `Manrope` (display)
- Body: `text-xs` (12px) di admin, `text-sm` (14px) di public
- Heading H1: `text-lg` admin, `text-4xl` public
- Spacing: 4px grid (Tailwind default)

### 4.4. Border Radius
- Buttons & inputs: `rounded` (4px)
- Cards: `rounded` (4px)
- Modal/Drawer: `rounded-md` (6px)

---

## 5. Migration Strategy (Bertahap)

### Fase A — Setup Foundation (1 hari)
1. ✅ Install PrimeVue + Aura preset (DONE)
2. Install assets dari template Genesis & Diamond:
   - Beli license PrimeVue Premium di https://primevue.org/templates/ (jika belum)
   - Atau adaptasi manual dari demo (legal, karena hanya inspirasi)
3. Pisahkan `PublicLayout.vue` dan `AdminLayout.vue`
4. Setup global tokens (CSS variables) di `resources/css/app.css`

### Fase B — Public Pages (2 hari)
1. Welcome.vue — hero + features + cara mengajukan + statistik
2. Faq.vue — accordion list dari `faq` table
3. Laman.vue — dynamic page dari `laman` table by slug
4. Inovasi public gallery & detail
5. Errors (404, maintenance)

### Fase C — Admin Foundation (2 hari)
1. AdminLayout dengan sidebar, topbar, breadcrumb
2. Komponen reusable (PageHeader, StatCard, DataTableCard)
3. Theme toggle (light/dark)
4. Global search (Cmd+K)
5. Notifications dropdown

### Fase D — Pemohon Pages (2 hari)
1. Dashboard
2. Permohonan list (DataTable)
3. Permohonan create wizard (Stepper)
4. Permohonan detail
5. Permohonan edit
6. Profil
7. Notifikasi inbox

### Fase E — Pembahas + Evaluator (2 hari)
1. Pembahasan list + detail + form validasi
2. Evaluasi list + form penilaian per indikator/parameter
3. Laporan masing-masing role

### Fase F — Administrator (3 hari)
1. Master data CRUD (indikator, parameter, urusan, wilayah)
2. CMS CRUD (laman, faq, slider)
3. Users + role assignment
4. Settings (jadwal, sistem)
5. Log viewer (aktivitas, notifikasi)
6. Laporan + export

### Fase G — Superadmin (1 hari)
1. Roles + permissions CRUD
2. Menu CRUD dengan drag-drop tree
3. Settings integrasi (SSO, WhatsApp, Juri, Monografi)

### Fase H — Polish & Test (2 hari)
1. Responsive mobile
2. Dark mode
3. Accessibility (keyboard nav, ARIA)
4. Performance (lazy load, code split)
5. E2E tests (Playwright/Pest browser)

**Total estimasi:** ±15 hari kerja untuk redesign full.

---

## 6. Reference Mapping

| Kebutuhan JARSIPLUS              | Genesis (Public)         | Diamond (Admin)         |
|----------------------------------|--------------------------|-------------------------|
| Landing hero                     | Travel Hero              | —                       |
| Feature grid                     | Travel scale gallery     | —                       |
| Cara mengajukan (steps)          | Plan Your Holiday        | —                       |
| Galeri inovasi                   | Escape Gallery           | —                       |
| Footer                           | Travel Footer            | —                       |
| Login page                       | Sign In                  | —                       |
| Sidebar + Topbar                 | —                        | Apps page shell         |
| Dashboard stat cards             | —                        | Dashboard               |
| DataTable with filters/actions   | —                        | List pages              |
| Form wizard                      | —                        | Form Layouts            |
| Detail page (split layout)       | —                        | Detail pages            |
| User profile                     | Account General          | Profile                 |
| Settings                         | —                        | Settings                |
| Empty states                     | —                        | Diamond pattern         |
| Notifications                    | —                        | Topbar dropdown         |

---

## 7. Tugas Saat Ini (Setelah Redesign Disetujui)

1. **Mulai Fase A:** Pisah `PublicLayout` & `AdminLayout`, sudah ada draft `AdminLayout` monochrome.
2. **Lanjut Fase B:** Bangun `Welcome.vue` dengan brand colors + hero.
3. Sisanya bertahap sesuai urutan fase.

Setuju dengan rencana ini? Atau ada yang perlu di-adjust dulu sebelum mulai eksekusi?
