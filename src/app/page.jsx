import Link from 'next/link'
import EnrolForm from '@/components/EnrolForm'

const SPECIALISMS = [
  'Data Analysis', 'Data Science', 'AI & Machine Learning',
  'Data Engineering', 'Data Storytelling',
]

const COURSES = [
  { title: 'Data Analysis', summary: 'Clean, analyse and report on data using spreadsheets, SQL and BI tools. Build dashboards that communicate clearly.', duration: '8 weeks', level: 'Beginner' },
  { title: 'Data Science', summary: 'Build and evaluate predictive models in Python. Work with real datasets from day one.', duration: '10 weeks', level: 'Intermediate' },
  { title: 'AI & Machine Learning', summary: 'Train, test and deploy machine learning solutions. From linear regression to neural networks.', duration: '12 weeks', level: 'Intermediate' },
  { title: 'Data Engineering', summary: 'Build reliable data pipelines and databases. Learn SQL, dbt, Airflow and cloud storage.', duration: '10 weeks', level: 'Intermediate' },
  { title: 'Data Storytelling', summary: 'Turn analysis into dashboards and presentations that decision-makers act on.', duration: '6 weeks', level: 'All levels' },
]

const WORK = [
  { title: 'Data Literacy Bootcamp for Professionals', type: 'Training', year: '2024', description: 'Trained 40 professionals across three organisations on data analysis using Excel and Power BI.' },
  { title: 'Sales Dashboard for a Retail Business', type: 'Project', year: '2024', description: 'Built an interactive Power BI dashboard tracking monthly revenue, stock and regional sales.' },
  { title: 'Intro to Python for Data Science', type: 'Training', year: '2023', description: 'Led a 4-week Python course for 25 career switchers, focused on pandas and data visualisation.' },
]

const SAYS = [
  { name: 'Adewale O.', role: 'Financial analyst', quote: 'The data analysis course changed how I approach my work. Real datasets, real feedback, real skills.' },
  { name: 'Chidinma N.', role: 'Career switcher', quote: 'I joined with zero Python experience. After the data science programme I landed my first analyst role.' },
  { name: 'Emeka F.', role: 'Team lead, logistics firm', quote: 'We sent four team members to Dataversity for the storytelling programme. Our reports have never looked better.' },
]

export default function Home({ searchParams }) {
  const enrolled = searchParams?.enrolled === '1'
  const error    = searchParams?.error === 'missing'

  return (
    <>
      <header className="bar">
        <Link href="/" className="brand">
          <img src="/mark.svg" alt="Dataversity logo" width={34} height={34} />
          Dataversity <span>Tech Academy</span>
        </Link>
        <nav>
          <Link href="#courses">Courses</Link>
          <Link href="#work">Our work</Link>
          <Link href="#enrol">Enrol</Link>
        </nav>
      </header>

      <main>
        {/* HERO */}
        <section className="hero">
          <div>
            <h1>Learn to work with data, from your first spreadsheet to production pipelines.</h1>
            <p>
              Practical training in{' '}
              {SPECIALISMS.map((s, i) => (
                <span key={s}>{i > 0 && ', '}{s}</span>
              ))}.
            </p>
            <a className="btn" href="#enrol" style={{ marginTop: '24px', display: 'inline-block' }}>
              Enrol now
            </a>
          </div>
          <div className="bars" aria-hidden="true">
            <span /><span /><span />
          </div>
        </section>

        {/* COURSES */}
        <section className="wrap" id="courses">
          <h2>Courses</h2>
          <div className="grid">
            {COURSES.map(c => (
              <article className="card" key={c.title}>
                <h3>{c.title}</h3>
                <p>{c.summary}</p>
                <p className="meta">{c.duration} · {c.level}</p>
              </article>
            ))}
          </div>
        </section>

        {/* PAST WORK */}
        <section className="wrap" id="work">
          <h2>Our work and past trainings</h2>
          {WORK.map(w => (
            <article className="row" key={w.title}>
              <div>
                <h3>{w.title}</h3>
                <p>{w.description}</p>
              </div>
              <p className="meta" style={{ whiteSpace: 'nowrap' }}>{w.type} · {w.year}</p>
            </article>
          ))}
        </section>

        {/* TESTIMONIALS */}
        <section className="wrap" style={{ background: 'var(--paper)' }}>
          <h2>What learners say</h2>
          <div className="grid">
            {SAYS.map(s => (
              <blockquote className="card" key={s.name}>
                <p>&ldquo;{s.quote}&rdquo;</p>
                <footer>{s.name}, {s.role}</footer>
              </blockquote>
            ))}
          </div>
        </section>

        {/* ENROL */}
        <section className="narrow" id="enrol">
          <h2>Enrol</h2>
          <p style={{ color: 'var(--mute)' }}>Fill in this form and we will contact you within 24 hours.</p>
          {enrolled && <p className="ok">Thank you! We have your request and will be in touch soon.</p>}
          {error    && <p className="err">Please enter your name and a valid email address.</p>}
          <EnrolForm courses={COURSES.map(c => c.title)} />
        </section>
      </main>

      <footer className="foot">
        © {new Date().getFullYear()} Dataversity Tech Academy. All rights reserved.
      </footer>
    </>
  )
}
