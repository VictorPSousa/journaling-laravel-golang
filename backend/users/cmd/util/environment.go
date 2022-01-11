package util

import (
	"os"
	"strings"
)

func GetVariable(name string) (value string) {
	for _, e := range os.Environ() {
		pair := strings.SplitN(e, "=", 2)
		if pair[0] == name {
			value = pair[1]
			return
		}
	}
	return
}
