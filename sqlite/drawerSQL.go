package sqlite

func GetMarkDown(id int) (md string, err error) {
	tx, err := NewTx()
	if err != nil {
		return
	}
	defer CloseTx(tx)
	err = tx.QueryRowx("select markdown from article where id=?", id).Scan(&md)
	if err != nil {
		return
	}
	tx.Commit()
	return
}

func SetHtml(id int, title, htmlres string) (err error) {
	tx, err := NewTx()
	if err != nil {
		return
	}
	defer CloseTx(tx)
	_, err = tx.Exec("update article set title=?, html=? where id=?", title, htmlres, id)
	if err != nil {
		return
	}
	tx.Commit()
	return
}
