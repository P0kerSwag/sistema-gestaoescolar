<?php
declare(strict_types=1);
?><!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
  <meta name="theme-color" content="#f6f7fb">
  <meta name="description" content="Gestão escolar simples, organizada e disponível offline.">
  <link rel="manifest" href="manifest.webmanifest">
  <link rel="stylesheet" href="styles.css">
  <title>Educa · Gestão escolar</title>
</head>
<body>
  <div class="app-shell">
    <aside class="sidebar" aria-label="Navegação principal">
      <a class="brand" href="#inicio" aria-label="Educa, início"><span class="brand-mark">e.</span><span>educa<span class="brand-dot">.</span><small>GESTÃO ESCOLAR</small></span></a>
      <div class="school-switch"><span class="school-icon">✳</span><span><strong>Escola Horizonte</strong><small>Ano letivo · 2026</small></span><span class="chevron">⌄</span></div>
      <p class="nav-label">MENU PRINCIPAL</p>
      <nav class="nav-links">
        <button class="nav-link active" data-view="inicio"><span>⌂</span>Visão geral</button>
        <button class="nav-link" data-view="alunos"><span>♙</span>Alunos <b id="nav-student-count">0</b></button>
        <button class="nav-link" data-view="turmas"><span>▦</span>Turmas <b id="nav-class-count">0</b></button>
        <button class="nav-link" data-view="academico"><span>▤</span>Notas e frequência</button>
      </nav>
      <div class="sidebar-bottom"><div class="offline-badge"><i></i> Dados salvos neste dispositivo</div><div class="profile"><div class="avatar">MA</div><span><strong>Marina Alves</strong><small>Coordenação</small></span><span class="chevron">···</span></div></div>
    </aside>
    <main class="main-content">
      <header class="topbar"><div class="breadcrumb"><span>Escola Horizonte</span><span>/</span><strong id="crumb">Visão geral</strong></div><div class="top-actions"><span class="today" id="today"></span><button class="icon-btn" id="help-button" aria-label="Ajuda">?</button><div class="avatar small-avatar">MA</div></div></header>
      <div class="page-wrap">
        <section class="view active" id="view-inicio">
          <div class="welcome-row"><div><p class="eyebrow">ACOMPANHAMENTO DO ANO LETIVO</p><h1>Bom dia, Marina <span>✳</span></h1><p class="subheading">Acompanhe o que está acontecendo na sua escola.</p></div><button class="button primary" data-action="new-student"><span>＋</span> Novo aluno</button></div>
          <div class="stat-grid">
            <article class="stat-card"><div class="stat-top"><span>Alunos matriculados</span><span class="stat-icon lilac">♙</span></div><div class="stat-value" id="stat-students">0</div><div class="stat-foot"><span class="trend">↗</span> ativos neste ano letivo</div></article>
            <article class="stat-card"><div class="stat-top"><span>Turmas ativas</span><span class="stat-icon peach">▦</span></div><div class="stat-value" id="stat-classes">0</div><div class="stat-foot">distribuídas por etapa</div></article>
            <article class="stat-card"><div class="stat-top"><span>Média geral</span><span class="stat-icon mint">◒</span></div><div class="stat-value"><span id="stat-average">—</span><small>/ 10</small></div><div class="stat-foot"><span class="trend">↗</span> média das notas lançadas</div></article>
            <article class="stat-card"><div class="stat-top"><span>Frequência média</span><span class="stat-icon blue">◷</span></div><div class="stat-value"><span id="stat-attendance">—</span><small>%</small></div><div class="stat-foot">presença registrada</div></article>
          </div>
          <div class="dashboard-grid">
            <section class="panel performance-panel"><div class="panel-heading"><div><h2>Resumo de desempenho</h2><p>Visão geral dos registros acadêmicos</p></div><span class="period-chip">Ano letivo 2026</span></div><div class="performance-content"><div class="donut" id="donut"><div><strong id="donut-average">—</strong><small>média geral</small></div></div><div class="legend"><div><i class="dot green"></i><span>Acima da média<small>Notas a partir de 7,0</small></span><strong id="above-count">0</strong></div><div><i class="dot yellow"></i><span>Em desenvolvimento<small>Notas entre 5,0 e 6,9</small></span><strong id="middle-count">0</strong></div><div><i class="dot red"></i><span>Atenção necessária<small>Notas abaixo de 5,0</small></span><strong id="below-count">0</strong></div></div></div></section>
            <section class="panel activity-panel"><div class="panel-heading"><div><h2>Acompanhe de perto</h2><p>Alunos que podem precisar de atenção</p></div><span class="sparkle">✦</span></div><div id="attention-list" class="attention-list"></div></section>
          </div>
          <section class="panel recent-panel"><div class="panel-heading"><div><h2>Alunos recentes</h2><p>Últimos alunos adicionados</p></div><button class="text-button" data-view="alunos">Ver todos <span>→</span></button></div><div id="recent-students"></div></section>
        </section>
        <section class="view" id="view-alunos"><div class="page-title-row"><div><p class="eyebrow">CADASTROS</p><h1>Alunos</h1><p class="subheading">Gerencie as informações dos estudantes.</p></div><button class="button primary" data-action="new-student"><span>＋</span> Novo aluno</button></div><div class="panel list-panel"><div class="toolbar"><label class="search-box"><span>⌕</span><input id="student-search" type="search" placeholder="Buscar por nome ou e-mail"></label><select id="student-class-filter" aria-label="Filtrar por turma"><option value="">Todas as turmas</option></select><span class="result-count" id="student-results"></span></div><div id="students-table"></div></div></section>
        <section class="view" id="view-turmas"><div class="page-title-row"><div><p class="eyebrow">ORGANIZAÇÃO</p><h1>Turmas</h1><p class="subheading">Organize seus alunos por turma e etapa.</p></div><button class="button primary" data-action="new-class"><span>＋</span> Nova turma</button></div><div id="classes-grid" class="classes-grid"></div></section>
        <section class="view" id="view-academico"><div class="page-title-row"><div><p class="eyebrow">ACOMPANHAMENTO</p><h1>Notas e frequência</h1><p class="subheading">Consulte e atualize o acompanhamento acadêmico.</p></div><button class="button primary" data-action="new-record"><span>＋</span> Lançar registro</button></div><div class="panel list-panel"><div class="toolbar"><label class="search-box"><span>⌕</span><input id="record-search" type="search" placeholder="Buscar aluno ou disciplina"></label><select id="record-class-filter" aria-label="Filtrar por turma"><option value="">Todas as turmas</option></select><span class="result-count" id="record-results"></span></div><div id="records-table"></div></div></section>
      </div>
      <footer class="app-footer"><span>Educa · Gestão Escolar</span><span>Seus dados ficam salvos neste dispositivo <i></i></span></footer>
    </main>
  </div>
  <nav class="mobile-nav" aria-label="Navegação mobile"><button class="active" data-view="inicio"><span>⌂</span>Início</button><button data-view="alunos"><span>♙</span>Alunos</button><button data-view="turmas"><span>▦</span>Turmas</button><button data-view="academico"><span>▤</span>Acadêmico</button></nav>
  <div class="toast" id="toast" role="status" aria-live="polite"></div>
  <dialog id="editor-dialog" class="editor-dialog"><form id="editor-form" novalidate><div class="dialog-head"><div><span class="dialog-kicker" id="dialog-kicker">CADASTRO</span><h2 id="dialog-title">Novo aluno</h2><p id="dialog-subtitle">Preencha as informações abaixo.</p></div><button type="button" class="close-btn" data-close aria-label="Fechar">×</button></div><div id="form-fields" class="form-fields"></div><div class="dialog-error" id="form-error" role="alert"></div><div class="dialog-actions"><button type="button" class="button secondary" data-close>Cancelar</button><button type="submit" class="button primary" id="submit-button">Salvar aluno</button></div></form></dialog>
  <dialog id="confirm-dialog" class="confirm-dialog"><div class="confirm-symbol">!</div><h2 id="confirm-title">Excluir registro?</h2><p id="confirm-text">Esta ação não poderá ser desfeita.</p><div class="dialog-actions"><button class="button secondary" data-close>Cancelar</button><button class="button danger" id="confirm-delete">Excluir</button></div></dialog>
  <script src="app.js" defer></script>
</body>
</html>
