set foreign_key_checks=0;

drop table if exists patient;
drop table if exists doctor;
drop table if exists appointment;
drop table if exists request;
drop table if exists equipment;
drop table if exists study;
drop table if exists series;
drop table if exists element;
drop table if exists region;

set foreign_key_checks=1;

create table patient(patient_id integer auto_increment, name varchar(255), birthday date, address varchar(255), primary key(patient_id));
create table doctor(doctor_id integer auto_increment, name varchar(255), speciality varchar(255), primary key(doctor_id));
create table appointment(patient_id integer, doctor_id integer, date timestamp, office varchar(255), primary key(patient_id, doctor_id, date), foreign key(patient_id) references patient(patient_id), foreign key(doctor_id) references doctor(doctor_id));
create table request(request_number integer auto_increment, patient_id integer not null, doctor_id integer not null, date timestamp, primary key(request_number), foreign key(patient_id, doctor_id) references appointment(patient_id, doctor_id));
create table equipment(manufacturer varchar(255), serial_number varchar(255), model varchar(255), primary key(manufacturer, serial_number));
create table study(request_number integer, description varchar(255), date timestamp, doctor_id integer not null, manufacturer varchar(255) not null, serial_number varchar(255) not null, primary key(request_number, description), foreign key(request_number) references request(request_number), foreign key(doctor_id) references doctor(doctor_id), foreign key(manufacturer, serial_number) references equipment(manufacturer, serial_number));
create table series(series_id integer auto_increment, name varchar(255), base_url varchar(255), request_number integer not null, description varchar(255) not null, primary key(series_id), foreign key(request_number, description) references study(request_number, description));
create table element(series_id integer, element_index integer, primary key(series_id, element_index), foreign key(series_id) references series(series_id) );
create table region(series_id integer, element_index integer, x1 float, y1 float, x2 float, y2 float, primary key(series_id, element_index, x1, y1, x2, y2), foreign key(series_id, element_index) references element(series_id, element_index));

insert into patient values (default, "Luis Carlos", "1994-03-14", "Rua da Tulipa, nº20");
insert into patient values (default, "João Silva", "1991-02-02", "Rua da Iris, nº1");
insert into patient values (default, "Marcos Freitas", "1980-11-01", "Rua do Vale, nº11");

insert into doctor values (default, "Rui Sampaio", "Technical Specialist");
insert into doctor values (default, "Vitor Lucas", "Technical Specialist");
insert into doctor values (default, "Sara Sousa", "Technical Specialist");