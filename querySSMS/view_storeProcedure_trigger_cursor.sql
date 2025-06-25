use basisdata2

select * from barang

select * from detail_transaksi_masuk

select * from transaksi_keluar

select * from detail_transaksi_keluar order by id_barang

select * from customer

select * from [user]

select * from sys.views

select * from sys.procedures

select * from sys.triggers

SELECT OBJECT_NAME(object_id) AS ObjectName, definition AS ObjectDefinition
FROM sys.sql_modules WHERE definition LIKE '%DECLARE%CURSOR%';

-- menampilkan transaksi masuk berdasarkan tanggal, nama supplier, dan metode pembayaran
alter view vw_riwayat_masuk as
select m.id_transaksi_masuk IDTransaksiMasuk, m.tanggal Tanggal, s.nama_supplier Supplier, m.metode_pembayaran Pembayaran, sum(dm.jumlah) JumlahBarang, sum(dm.harga*dm.jumlah) TotalHarga
from transaksi_masuk m, supplier s, detail_transaksi_masuk dm
where m.id_transaksi_masuk=dm.id_transaksi_masuk and m.id_supplier=s.id_supplier
group by m.id_transaksi_masuk, m.tanggal, s.nama_supplier, m.metode_pembayaran

select * from vw_riwayat_masuk

create view vw_riwayat_keluar as
select tk.id_transaksi_keluar IDTransaksiKeluar, tk.tanggal Tanggal, c.nama_customer Customer, tk.metode_pembayaran Pembayaran, sum(dtk.jumlah) JumlahBarang, sum(dtk.harga*dtk.jumlah) TotalHarga
from transaksi_keluar tk, customer c, detail_transaksi_keluar dtk
where tk.id_transaksi_keluar = dtk.id_transaksi_keluar and tk.id_customer = c.id_customer
group by tk.id_transaksi_keluar, tk.id_customer, tk.tanggal, c.nama_customer, tk.metode_pembayaran

select * from vw_riwayat_keluar order by Tanggal desc


alter view margin_perbarang as
select b.id_barang IDBarang, b.nama_barang NamaBarang, avg(dm.harga) HargaBeli, b.harga_jual HargaJual, sum(dk.harga*dk.jumlah)/sum(dk.jumlah)  HargaTerjualAvg, sum(dk.jumlah) JumlahTerjual, (dk.harga-dm.harga)*dk.jumlah MarginPerUnitAvg, (avg(dk.harga)-avg(dm.harga))*sum(dk.jumlah) TotalLaba
from barang b, detail_transaksi_keluar dk, detail_transaksi_masuk dm
where b.id_barang=dk.id_barang and dm.id_barang=b.id_barang
group by b.id_barang, b.nama_barang, b.harga_jual

select * from margin_perbarang order by IDBarang
select * from detail_transaksi_keluar order by id_barang, id_transaksi_keluar


alter view margin_perbarang_percustomer as
select b.id_barang IDBarang, b.nama_barang NamaBarang, c.id_customer IDCustomer, c.nama_customer Customer, avg(dm.harga) HargaBeli, b.harga_jual HargaJual, avg(dk.harga) HargaTerjual, sum(dk.jumlah) JumlahTerjual, (avg(dk.harga)-avg(dm.harga)) MarginPerUnit, (avg(dk.harga)-avg(dm.harga))*sum(dk.jumlah) TotalLaba
from barang b, detail_transaksi_keluar dk, detail_transaksi_masuk dm, transaksi_keluar tk, customer c
where b.id_barang=dk.id_barang and dm.id_barang=b.id_barang and dk.id_transaksi_keluar=tk.id_transaksi_keluar and tk.id_customer=c.id_customer
group by b.id_barang, b.nama_barang, b.harga_jual, c.nama_customer, c.id_customer



alter view margin_perbarang_percustomer as
select b.id_barang IDBrg, b.nama_barang NmBrg, c.id_customer IDCust, c.nama_customer NmCust,
avgHBeli.hasil AvgHargaBeli,
sum(dk.harga*dk.jumlah)/sum(dk.jumlah) AvgHargaTerjual, 
sum(dk.jumlah) JmlTerjual,
sum((dk.harga-avgHBeli.hasil)*dk.jumlah)/sum(dk.jumlah) AvgMarginPerUnit,
sum((dk.harga-avgHBeli.hasil)*dk.jumlah) TotalLaba
from barang b, (select id_barang, sum(jumlah*harga)/sum(jumlah) as hasil from detail_transaksi_masuk group by id_barang) avgHBeli, detail_transaksi_keluar dk, transaksi_keluar tk, customer c
where b.id_barang=avgHBeli.id_barang and b.id_barang=dk.id_barang and dk.id_transaksi_keluar=tk.id_transaksi_keluar and tk.id_customer=c.id_customer
group by b.id_barang, b.nama_barang, c.id_customer, c.nama_customer, avgHBeli.hasil

select * from margin_perbarang_percustomer order by IDBrg
select sum(totallaba) from margin_perbarang_percustomer group by IDBarang order by IDBarang
select sum(TotalLaba) from margin_perbarang 
select * from margin_perbarang

alter view penjualan_barang_harian as
select tk.tanggal Tanggal, b.nama_barang NamaBarang, avgHBeli.avg_harga_beli HargaBeli,
sum(dk.harga*dk.jumlah)/sum(dk.jumlah) HargaTerjual, 
sum(dk.jumlah) JumlahTerjual,
(sum(dk.harga*dk.jumlah) - (avgHBeli.avg_harga_beli * sum(dk.jumlah))) Margin
from barang b, 
(select id_barang, sum(jumlah*harga)/sum(jumlah) avg_harga_beli from detail_transaksi_masuk group by id_barang) avgHBeli,
detail_transaksi_keluar dk,
transaksi_keluar tk
where b.id_barang = avgHBeli.id_barang and b.id_barang = dk.id_barang and dk.id_transaksi_keluar = tk.id_transaksi_keluar
group by tk.tanggal, b.nama_barang, avgHBeli.avg_harga_beli


alter view penjualan_barang_harian as
select tk.tanggal

select sum(margin) from penjualan_barang_harian
select sum(TotalLaba) from margin_perbarang_percustomer
select * from detail_transaksi_keluar 11 12 14 15 brg
select * from barang
select * from transaksi_keluar order by tanggal desc
select * from penjualan_barang_harian order by Tanggal desc

-- penjualan harian dengan rentang tanggal
create procedure sp_margin_range_tgl @awal date, @akhir date as begin
	select * from penjualan_barang_harian p where p.Tanggal>=@awal and p.Tanggal<=@akhir order by tanggal desc
end
exec sp_margin_range_tgl '2024-04-21', '2024-04-30'

-- trigger barang masuk
create trigger trInsMasukD on detail_transaksi_masuk for insert as begin
	update barang set stok = stok+(select jumlah from inserted) where id_barang=(select id_barang from inserted)
end
-- versi dengan variabel
alter trigger trInsMasukD on detail_transaksi_masuk for insert as begin
	declare @id_barang int, @jumlah int
	select @id_barang=id_barang, @jumlah=jumlah from inserted
	update barang set stok = stok + @jumlah where id_barang = @id_barang
end
drop trigger trInsMasukD

-- trigger dtm del
alter trigger trDelDtm on detail_transaksi_masuk for delete as begin
	update barang set stok=stok-(select jumlah from deleted) where id_barang=(select id_barang from deleted)
end
drop trigger trDelDtm

delete from detail_transaksi_masuk where id_barang = 3 and id_transaksi_masuk = 10
select * from detail_transaksi_masuk where id_barang = 3 and id_transaksi_masuk = 10
select * from detail_transaksi_masuk
select * from barang
insert into detail_transaksi_masuk values (10, 3, 6, 144000)

-- trigger update,insert,delete di saat Masuk (DTM) - update stok
create trigger trDtm on detail_transaksi_masuk for insert, delete, update as begin
	-- inserted
	update barang set stok=stok+(select jumlah from inserted) where id_barang=(select id_barang from inserted)

	-- deleted
	update barang set stok=stok-(select jumlah from deleted) where id_barang=(select id_barang from deleted)
end

update detail_transaksi_masuk set jumlah=9 where id_transaksi_masuk=10 and id_barang=1
delete from detail_transaksi_masuk where id_barang=2 and id_transaksi_masuk=10
insert into detail_transaksi_masuk values(10,2,10,23460)

-- trigger update,insert,delete di saat Keluar (DTK) - update stok
create trigger trDtkUpdate on detail_transaksi_keluar for insert, delete, update as begin
	-- inserted
	update barang set stok=stok-(select jumlah from inserted) where id_barang=(select id_barang from inserted)
	-- deleted
	update barang set stok=stok+(select jumlah from deleted) where id_barang=(select id_barang from deleted)
end

select id_transaksi_masuk, sum(jumlah) jml from detail_transaksi_masuk where id_barang=1 group by id_barang, id_transaksi_masuk
select id_transaksi_keluar, sum(jumlah) jml from detail_transaksi_keluar where id_barang=1 group by id_barang, id_transaksi_keluar
select * from detail_transaksi_keluar
select * from barang
insert detail_transaksi_keluar values(1,2,2,23460)
delete detail_transaksi_keluar where id_barang=2 and id_transaksi_keluar=1
update detail_transaksi_keluar set jumlah=7 where id_transaksi_keluar=1 and id_barang=1

-- benarkan stok barang
exec spBenarkanStok
create procedure spBenarkanStok as begin
	declare @id_barang int, @jumlah int
	declare crIns cursor for select id_barang, sum(Masuk-Keluar) Jumlah from (
		select id_barang, sum(jumlah) Masuk, 0 Keluar from detail_transaksi_masuk group by id_barang
		union all
		select id_barang, 0 Masuk, sum(jumlah) Keluar from detail_transaksi_keluar group by id_barang ) x group by id_barang
	open crIns
	fetch next from crIns into @id_barang, @jumlah
	while (@@FETCH_STATUS=0) begin
		update barang set stok=@jumlah where id_barang=@id_barang
		fetch next from crIns into @id_barang, @jumlah
	end
	close crIns
	deallocate crIns
end

select * from transaksi_masuk
select id_transaksi_masuk, id_barang, harga from detail_transaksi_masuk order by id_transaksi_masuk desc
update detail_transaksi_masuk set harga=146000 where id_transaksi_masuk=8 and id_barang=1

-- sp update harga jual dengan margin 20% dari harga di transaksi masuk terakhir
create procedure spUpdateHargaJual as begin
	declare @idLastM int, @id_barang int, @harga decimal
	select top 1 @idLastM=id_transaksi_masuk from transaksi_masuk order by id_transaksi_masuk desc
	declare crNewestM cursor for select id_barang, harga from detail_transaksi_masuk dtm where id_transaksi_masuk = @idLastM
	open crNewestM
	fetch next from crNewestM into @id_barang, @harga
	while (@@FETCH_STATUS=0) begin
		update barang set harga_jual=@harga*1.2 where id_barang=@id_barang
		fetch next from crNewestM into @id_barang, @harga
	end
	close crNewestM
	deallocate crNewestM
end
exec spUpdateHargaJual

select top 1 id_transaksi_masuk from transaksi_masuk order by id_transaksi_masuk desc
select * from detail_transaksi_masuk order by id_transaksi_masuk desc
select * from barang

select * from detail_transaksi_masuk order by id_transaksi_masuk desc
select * from barang

create procedure sp_margin_range_tgl @awal date, @akhir date as begin
	select * from penjualan_barang_harian p where p.Tanggal>=@awal and p.Tanggal<=@akhir order by tanggal desc
end
exec sp_margin_range_tgl '2024-04-21', '2024-04-30'

select b.nama_barang Barang, d.harga Harga, d.jumlah Jumlah, d.harga*d.jumlah Subtotal
from detail_transaksi_keluar d, barang b
where id_transaksi_keluar=2 and d.id_barang=b.id_barang

select b.nama_barang Barang, d.harga Harga, d.jumlah Jumlah, d.harga*d.jumlah Subtotal
from detail_transaksi_masuk d, barang b
where id_transaksi_masuk=2 and d.id_barang=b.id_barang