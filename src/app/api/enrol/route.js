import { NextResponse } from 'next/server'

export async function POST(request) {
  const data = await request.formData()
  // Honeypot check
  if (data.get('website')) {
    return NextResponse.redirect(new URL('/', request.url))
  }
  const name    = (data.get('name')    || '').trim()
  const email   = (data.get('email')   || '').trim()
  const phone   = (data.get('phone')   || '').trim()
  const course  = (data.get('course')  || '').trim()
  const message = (data.get('message') || '').trim()

  if (!name || !email) {
    return NextResponse.redirect(new URL('/?error=missing#enrol', request.url))
  }

  // In production: save to a database or send an email.
  // Placeholder — logs to Vercel function logs.
  console.log('New enrolment:', { name, email, phone, course, message })

  return NextResponse.redirect(new URL('/?enrolled=1#enrol', request.url))
}
