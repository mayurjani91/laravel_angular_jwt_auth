import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { JarwisService } from 'src/app/Services/jarwis.service';
import { TokenService } from 'src/app/Services/token.service';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit {
  constructor(public jarwis:JarwisService,private router:Router)
  {

    const ifLogin = localStorage.getItem('token');
    if(ifLogin == null)
    {
      // this.router.navigateByUrl('/login')
    }

    // alert(this.userExist)
  }

ngOnInit(): void {


}
logout()
{
 localStorage.removeItem('token')
 this.router.navigateByUrl('/login')

}
}
