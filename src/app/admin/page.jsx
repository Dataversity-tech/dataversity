export const metadata = { title: 'Admin – Dataversity Tech Academy' }

export default function AdminPage() {
  return (
    <main className="narrow" style={{paddingTop:'80px'}}>
      <h1>Admin panel</h1>
      <p>The full admin panel requires a database connection. Set <code>DATABASE_URL</code> in your Vercel environment variables, then the panel will show courses, past work, testimonials and enrolment requests.</p>
      <p>Until then, edit the static arrays in <code>src/app/page.jsx</code> to update the public site.</p>
    </main>
  )
}
