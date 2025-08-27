async function listResumes(){
  const res = await fetch('/api/list_resumes.php', { credentials:'include' });
  const j = await res.json();
  if(j.ok) return j.resumes; else { console.error(j); return []; }
}
