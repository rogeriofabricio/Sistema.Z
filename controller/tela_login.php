<div class="col-12 col-md-12">

  <label style="padding-bottom: 20px; width: 300px; text-align: center;"><h5>ACESSO A INTRANET</h5></label> 

  <form id="needs-validation" name="login_form" action="includes/process_login.php" method="POST" novalidate>

    <div class="form-row" style="width: 300px;">
      <div class="col-md-12 mb-3">
        <label for="validationCustom01">E-mail</label>
        <input type="text" class="form-control" name="email" id="validationCustom01" placeholder="exemplo@exemplo.com.br" required>
      </div>
    </div>

    <div class="form-row" style="width: 300px;">
      <div class="col-md-12 mb-3">
        <label for="validationCustom03">Senha</label>
        <input type="password" class="form-control" name="password" id="validationCustom02" placeholder="Digite sua senha" required>
      </div>
    </div>

    <button type="button" value="Login" onclick="formhash(this.form, this.form.password);"class="btn btn-primary">Login</button>
    <a href="registro.php?link=parceiroPL" style="margin-left: 45px; text-decoration: none; color: #999; font-size: 12px;">Criar uma conta nova</a>
  </form>
  
</div>