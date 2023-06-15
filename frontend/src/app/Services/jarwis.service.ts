'use strict';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class JarwisService {

  headers = new HttpHeaders({
    'Accept': 'application/json',
    'Authorization': `Bearer `+localStorage.getItem('token')
  });

  requestOptions = { headers: this.headers };
  constructor(private http:HttpClient, private router:Router) {

  }

  checkLogedIn(){
    return localStorage.getItem('token');
  }

  login(data:any)
  {
    return this.http.post('http://127.0.0.1:8000/api/login', data)
  }

  signup(data:any)
    {
      return this.http.post('http://127.0.0.1:8000/api/signup',data)
    }

    sendResetPasswordLink(data:any)
    {
      return this.http.post('http://127.0.0.1:8000/api/sendResetPasswordLink',data)
    }

    ResetPassword(data:any)
    {
      return this.http.post('http://127.0.0.1:8000/api/ResetPassword',data)
    }

    allBlogs()
    {
      return this.http.get('http://127.0.0.1:8000/api/allBlogs',this.requestOptions)
    }

    myBlogs()
    {
      return this.http.get('http://127.0.0.1:8000/api/myBlogs',this.requestOptions)
    }

    blogDetails(data:any)
    {
      return this.http.post('http://127.0.0.1:8000/api/blogDetails',{ id : data },this.requestOptions)
    }

    blogEdit(data:any)
    {
      return this.http.post('http://127.0.0.1:8000/api/blogEdit',{ id : data },this.requestOptions)
    }
    blogDelete(data:any)
    {
      return this.http.post('http://127.0.0.1:8000/api/blogDelete',{ id : data },this.requestOptions)
    }

    addBlog(data:any)
    {

      // console.log(data);
      this.headers = this.headers.set('enctype', 'multipart/form-data');
      this.requestOptions = { headers: this.headers };
      return this.http.post('http://127.0.0.1:8000/api/addBlog',data,this.requestOptions)
    }
    updateBlog(data:any)
    {

      // console.log(data);
      this.headers = this.headers.set('enctype', 'multipart/form-data');
      this.requestOptions = { headers: this.headers };
      return this.http.post('http://127.0.0.1:8000/api/updateBlog',data,this.requestOptions)
    }

    likeMe(data:any)
    {
      return this.http.post('http://127.0.0.1:8000/api/likeMe',{ id : data },this.requestOptions)
    }
}
