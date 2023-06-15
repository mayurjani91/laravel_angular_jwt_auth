import { Component } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { JarwisService } from 'src/app/Services/jarwis.service';

@Component({
  selector: 'app-response-reset',
  templateUrl: './response-reset.component.html',
  styleUrls: ['./response-reset.component.css']
})
export class ResponseResetComponent {
  error = null
  message = null
  public form = {
    password: null,
    password_confirmation: null,
    reset_token: null
    };
  constructor(private jarwis:JarwisService, private route:ActivatedRoute, private router:Router)
  {
    route.queryParams.subscribe(params => {
        this.form.reset_token = params['token']
    }
    )
  }
  onSubmit()
  {
    this.jarwis.ResetPassword(this.form).subscribe(
      data => this.handleResetRequest(data),
      error => this.handleError(error)
    )
  }

  handleResetRequest(data:any)
  {
    this.message = data.message;
    setTimeout(() => {                           // <<<---using ()=> syntax
      this.message = null;
      this.router.navigateByUrl('/login');
    }, 3000)

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
