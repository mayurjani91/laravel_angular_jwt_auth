import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class TokenService {
  constructor() { }

  handleToken(token:any)
{
 localStorage.setItem('token',token['access_token']);
}


}
