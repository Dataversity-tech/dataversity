# Dataversity Tech Academy

Public website for Dataversity Tech Academy — built with Next.js 14, deployable to Vercel in one click.

## Stack
- **Framework:** Next.js 14 (App Router)
- **Hosting:** Vercel

## Local development
```bash
npm install
npm run dev
```
Open http://localhost:3000

## Deploy to Vercel
1. Import this repo on vercel.com
2. Framework preset: **Next.js** (auto-detected)
3. No environment variables needed for the static version
4. For the enrolment form to save data, add `DATABASE_URL` in Vercel's Environment Variables settings

## Project structure
```
src/
  app/
    page.jsx          # Public homepage
    layout.jsx        # Root layout, fonts, meta
    globals.css       # Shared styles
    admin/page.jsx    # Admin panel shell
    api/enrol/route.js# Enrolment form handler
public/
  mark.svg            # Logo mark / favicon source
  icon.svg            # Next.js favicon (auto-detected)
  robots.txt
  sitemap.xml
vercel.json           # Security headers
```
