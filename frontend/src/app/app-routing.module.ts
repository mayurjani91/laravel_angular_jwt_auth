import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from './components/login/login.component';
import { SignupComponent } from './components/signup/signup.component';
import { ProfileComponent } from './components/profile/profile.component';
import { RequestResetComponent } from './components/password/request-reset/request-reset.component';
import { ResponseResetComponent } from './components/password/response-reset/response-reset.component';
import { BlogsComponent } from './components/blogs/blogs.component';
import { MyblogsComponent } from './components/myblogs/myblogs.component';
import { BlogDetailsComponent } from './components/blog-details/blog-details.component';




const appRoutes: Routes = [
  { path: "login", component: LoginComponent },
  { path: "signup", component: SignupComponent },
  { path: "profile", component: ProfileComponent },
  { path: "request-password-reset", component: RequestResetComponent },
  {path: "response-password-reset", component: ResponseResetComponent},
  {path: "blogs", component: BlogsComponent},
  {path: "myBlogs", component: MyblogsComponent},
  {path: "blogDetails/:id", component: BlogDetailsComponent},
  // {path: "blogEdit/:id", component: MyblogsComponent},




]
@NgModule({
  imports: [
    RouterModule.forRoot(appRoutes)
  ],
  exports: [
    RouterModule
  ]
})
export class AppRoutingModule { }
