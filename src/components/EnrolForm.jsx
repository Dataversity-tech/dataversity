'use client'

export default function EnrolForm({ courses }) {
  return (
    <form action="/api/enrol" method="POST">
      {/* honeypot */}
      <input
        type="text"
        name="website"
        style={{ position: 'absolute', left: '-9999px' }}
        tabIndex={-1}
        aria-hidden="true"
        autoComplete="off"
      />
      <label>
        Full name
        <input name="name" required />
      </label>
      <label>
        Email
        <input type="email" name="email" required />
      </label>
      <label>
        Phone
        <input name="phone" />
      </label>
      <label>
        Course
        <select name="course">
          <option value="">Not sure yet</option>
          {courses.map(c => (
            <option key={c}>{c}</option>
          ))}
        </select>
      </label>
      <label>
        Message
        <textarea name="message" rows={4} />
      </label>
      <button type="submit">Send enrolment request</button>
    </form>
  )
}
