import { Component, OnInit, ViewChild } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { ModalComponent } from '../../../bootstrap/modal/modal.component';

declare const $;

@Component({
  selector: 'app-category-list',
  templateUrl: './category-list.component.html',
  styleUrls: ['./category-list.component.css']
})
export class CategoryListComponent implements OnInit {

  categories = [];

  category = {
    name: ''
  }

  @ViewChild(ModalComponent)
  modal: ModalComponent;

  constructor(private http: HttpClient) {

  }

  ngOnInit() {
    this.getCategories();
  }

  submit() {
    const token = window.localStorage.getItem('token');
    this.http.post('http://localhost:8000/api/categories', this.category, { headers: { 'Authorization': `Bearer ${token}` } })
      .subscribe((category) => {
        this.modal.hide();
        this.getCategories();
      });
  }

  getCategories() {
    const token = window.localStorage.getItem('token');
    this.http.get<any>('http://localhost:8000/api/categories', { headers: { 'Authorization': `Bearer ${token}` } })
      .subscribe((response) => {
        this.categories = response.data;
      });
  }

  showModal() {
    this.modal.show();
  }

  hideModal(e: Event) {
    console.log(e);
  }
}
