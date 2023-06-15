import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { JarwisService } from 'src/app/Services/jarwis.service';
import { TokenService } from 'src/app/Services/token.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  public form = {
    email: null,
    password: null
  };
  constructor(private jarwis: JarwisService, private tokenS: TokenService, private router: Router) {

  }

  public error = null;
  onSubmit() {
    this.jarwis.login(this.form).subscribe(
      data => this.handleLogin(data),
      error => this.handleError(error)
    );

  }

  handleLogin(data:any)
  {
    this.tokenS.handleToken(data)
    this.router.navigateByUrl('/blogs')
  }

  handleError(error: any) {
    this.error = error.error;
    setTimeout(() => {                           // <<<---using ()=> syntax
      this.error = null;
    }, 3000)
  }


  ngOnInit(): void {

  }

}
