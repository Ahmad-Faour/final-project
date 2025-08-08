// ---------- TOAST HELPER ----------
function showToast(msg) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2000);
  }
  
  // ---------- DATE & TIME ----------
  function updateDateTime() {
    const now = new Date();
    document.getElementById('currentDate').textContent =
      now.toLocaleDateString(undefined, {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
      });
    document.getElementById('currentTime').textContent =
      now.toLocaleTimeString(undefined, {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
      });
  }
  updateDateTime();
  setInterval(updateDateTime, 1000);
  
  // ---------- THEME TOGGLE ----------
  const themeToggle = document.getElementById('themeToggle');
  themeToggle.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
    const icon = themeToggle.firstElementChild;
    icon.classList.toggle('fa-moon');
    icon.classList.toggle('fa-sun');
  });
  
  // ---------- POPUP FORM ----------
  const popup = document.getElementById('popupOverlay');
  const openBtns = document.querySelectorAll('#addPopupBtn, .inline-add');
  const closeBtn = document.getElementById('closePopup');
  
  openBtns.forEach((btn) =>
    btn.addEventListener('click', () => popup.classList.add('show'))
  );
  closeBtn.addEventListener('click', () => popup.classList.remove('show'));
  popup.addEventListener('click', (e) => {
    if (e.target === popup) popup.classList.remove('show');
  });
  
  // ---------- TASK MANAGEMENT  ----------
  const taskForm = document.getElementById('taskForm');
  const selfList = document.getElementById('selfTasks');
  const teamList = document.getElementById('teamTasks');
  let idCounter = 0;
  
  taskForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const task = {
      id: `t${idCounter++}`,
      name: taskForm.taskName.value.trim(),
      date: taskForm.dueDate.value,
      time: taskForm.dueTime.value,
      who: taskForm.assigneeName.value.trim(),
      type: taskForm.taskType.value,
    };
    insertTask(task);
    taskForm.reset();
    popup.classList.remove('show');
    showToast('Task added');
  });
  
  function insertTask(t) {
    const el = document.createElement('div');
    el.className = 'task';
    el.id = t.id;
  
    // top row
    const top = document.createElement('div');
    top.className = 'task-top';
  
    const cb = document.createElement('input');
    cb.type = 'checkbox';
    cb.addEventListener('change', () =>
      text.classList.toggle('completed', cb.checked)
    );
  
    const text = document.createElement('p');
    text.contentEditable = true;
    text.textContent = t.name;
  
    const del = document.createElement('button');
    del.innerHTML = '<i class="fa-solid fa-trash-can"></i>';
    del.addEventListener('click', () => {
      if (confirm('Delete this task?')) {
        el.remove();
        showToast('Task deleted');
      }
    });
  
    top.append(cb, text, del);
  
    // bottom row
    const bottom = document.createElement('div');
    bottom.className = 'task-bottom';
    bottom.innerHTML = `
      <span><i class="fa-solid fa-calendar-day"></i> ${t.date}</span>
      <span><i class="fa-regular fa-clock"></i> ${t.time}</span>
      <span>${t.who}</span>
    `;
  
    el.append(top, bottom);
    (t.type === 'self' ? selfList : teamList).append(el);
  
    // highlight overdue
    const due = new Date(`${t.date}T${t.time}`);
    if (Date.now() > due.getTime()) {
      el.querySelectorAll('.task-bottom span').forEach((s) => {
        s.style.color = 'var(--danger)';
      });
    }
  }
  