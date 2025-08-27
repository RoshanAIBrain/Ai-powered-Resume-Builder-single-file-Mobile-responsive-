async function saveToServer(resumeId = null){
  const payload = {
    id: resumeId,               // null for create, or existing id to update
    title: state.profile.name || 'Untitled Resume',
    template: state.template,
    color: state.color,
    data: state
  };
  const res = await fetch('/api/save_resume.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    credentials: 'include', // include cookies for session if using auth
    body: JSON.stringify(payload)
  });
  const j = await res.json();
  if(j.ok) { alert('Saved — ID: ' + j.id); return j.id; }
  else { alert('Save error: ' + (j.error||JSON.stringify(j))); }
}
