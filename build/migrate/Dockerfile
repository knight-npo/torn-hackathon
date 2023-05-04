FROM migrate/migrate

COPY ./migrations /migrations
RUN apk add --update --no-cache ca-certificates tzdata

ENTRYPOINT ["migrate"]
