import jsPDF from 'jspdf'

export function generatePDF(tasks) {
  const doc = new jsPDF()

  doc.setFontSize(20)
  doc.text('Task Report', 10, 20)

  let y = 30
  tasks.forEach((task, index) => {
    const { title, status, completed_at, assigned_user, created_at } = task
    const employeeName = assigned_user ? assigned_user.name : 'N/A'

    const startTime = new Date(created_at)
    const endTime = completed_at ? new Date(completed_at) : new Date()
    const timeDiff = Math.abs(endTime - startTime)
    const hours = timeDiff / (1000 * 60 * 60)

    const text = `Task ${index + 1}:
      - Title: ${title}
      - Status: ${status}
      - Time Taken (hours): ${hours.toFixed(2)}
      - Assigned Employee: ${employeeName}`

    doc.setFontSize(12)
    doc.text(text, 10, y)

    y += 40
  })

  const today = new Date().toLocaleDateString()
  doc.save(`task_report-${today}.pdf`)
}
