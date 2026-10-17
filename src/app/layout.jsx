import './globals.css'

export const metadata = {
  title: 'Dataversity Tech Academy',
  description: 'Practical training in data analysis, data science, AI and machine learning, data engineering and data storytelling.',
  keywords: ['data analysis', 'data science', 'machine learning', 'data engineering', 'data storytelling', 'tech training', 'Nigeria'],
  openGraph: {
    title: 'Dataversity Tech Academy',
    description: 'Practical training in data analysis, data science, AI and machine learning, data engineering and data storytelling.',
    type: 'website',
    url: 'https://dataversity-tech.vercel.app',
  },
  twitter: {
    card: 'summary',
    title: 'Dataversity Tech Academy',
    description: 'Practical training in data, from first spreadsheets to production pipelines.',
  },
}

export default function RootLayout({ children }) {
  return (
    <html lang="en">
      <head>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossOrigin="anonymous" />
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;700;800&display=swap" rel="stylesheet" />
      </head>
      <body>{children}</body>
    </html>
  )
}
