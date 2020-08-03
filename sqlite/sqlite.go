package sqlite

import (
	"github.com/jmoiron/sqlx"

	_ "github.com/mattn/go-sqlite3" //sqlite3
)

var sqldb, sqlerr = sqlx.Open("sqlite3", "./blog.db")

func init() {
	if _, err := sqldb.Exec("PRAGMA recursive_triggers = TRUE"); err != nil {
		panic(err)
	}
}

// NewTx get a new sqlite transaction
// use defer to CloseTx(CloseDB as well)
func NewTx() (tx *sqlx.Tx, err error) {
	if sqlerr != nil {
		err = sqlerr
		return
	}
	tx, err = sqldb.Beginx()
	return
}

// CloseTx close a transaction
func CloseTx(tx *sqlx.Tx) error {
	return tx.Rollback()
}

// CloseDB close the db conn
func CloseDB() error {
	if err := sqldb.Ping(); err != nil {
		return sqldb.Close()
	}
	return nil
}
