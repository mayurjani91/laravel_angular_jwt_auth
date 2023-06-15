import { Component, OnInit } from '@angular/core';
import { JarwisService } from 'src/app/Services/jarwis.service';

@Component({
  selector: 'app-request-reset',
  templateUrl: './request-reset.component.html',
  styleUrls: ['./request-reset.component.css']
})
export class RequestResetComponent implements OnInit{
  error = null
  message = null
  public form = {
    email: null
  };
  constructor(private jarwis:JarwisService)
  {

  }
  onSubmit()
  {
    this.jarwis.sendResetPasswordLink(this.form).subscribe(
      data => this.handleResetRequest(data),
      error => this.handleError(error)
    )
  }

  handleResetRequest(data:any)
  {
    this.message = data.message;
    setTimeout(() => {                           // <<<---using ()=> syntax
      this.message = null;
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
