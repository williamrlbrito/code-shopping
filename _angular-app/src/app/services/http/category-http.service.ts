import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class CategoryHttpService {

  constructor(private http: HttpClient) { }

  list() {
    const token = window.localStorage.getItem('token');
    return this.http.get<any>('http://localhost:8000/api/categories', { headers: { 'Authorization': `Bearer ${token}` } });
  }

  get() {

  }

  create() {

  }

  update() {

  }


}
