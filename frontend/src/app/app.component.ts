import { Component,OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit{
  title = 'frontend';

  checkToken:any = null;
constructor(private router:Router)
{

}

ngOnInit(): void {
  this.checkToken = localStorage.getItem('token');
  if(this.checkToken === null)
  {
    this.router.navigateByUrl('/login')
  }
}



}
