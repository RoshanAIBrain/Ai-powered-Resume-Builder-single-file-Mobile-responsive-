async function loadFromServer(id){
  const res = await fetch('/api/get_resume.php?id=' + encodeURIComponent(id), { credentials:'include' });
  const j = await res.json();
  if(j.ok && j.resume){
    Object.assign(state, j.resume.data);
    state.template = j.resume.template;
    state.color = j.resume.accent_color;
    render();
  } else {
    alert('Load error: ' + (j.error || 'unknown'));
  }
}
