import { Component, OnInit } from '@angular/core';
import { JarwisService } from 'src/app/Services/jarwis.service';
import { TokenService } from 'src/app/Services/token.service';
import { Router } from '@angular/router';


@Component({
  selector: 'app-signup',
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.css']
})
export class SignupComponent implements OnInit {
  constructor(private jarwis:JarwisService, private tokenS:TokenService, private router: Router)
  {

  }
public form ={
  email:null,
  name:null,
  password:null,
  password_confirmation:null
}
 public error=null;
 onSubmit()
 {
   this.jarwis.signup(this.form).subscribe(
     data => this.handleSignUp(data),
     error => this.handleError(error)
   );
 }
  handleSignUp(data: any): void {
    console.log(data);
    this.tokenS.handleToken(data)
    this.router.navigateByUrl('/profile')
  }

 handleError(error:any)
{
  this.error = error.error;
  setTimeout(()=>{                           // <<<---using ()=> syntax
    this.error = null;
}, 3000)
  // alert(this.error);

}
  ngOnInit(): void {

  }
}
